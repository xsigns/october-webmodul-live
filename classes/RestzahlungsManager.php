<?php

namespace Xsigns\Fewo\Classes;

use Illuminate\Support\Facades\DB;
use Xsigns\Fewo\Models\GlobalSettings;
use Mail;

class RestzahlungsManager
{
    private static $modulname = 'Restzahlungen';

    public static function checkRestzahlungen($openPaymentsToHandle = null, string $actor = 'Automatik')
    {
        self::debug('Überprüfung Restzahlungen für ' . date('Y-m-d', time()) . ' gestartet.');

        $status = array();
        $restzahlungen = self::bearbeiteRestzahlungen($openPaymentsToHandle, $actor);

        $status['ZAHLUNGEN'] = $restzahlungen;
        $status['MESSAGE'] = 'Ausgeführt am ' . date('Y-m-d', time());

        Mail::send('xsigns.fewo::mail.zahlungsStatus', $status, function($message) {
            $message->from(GlobalSettings::get('mailaddress'), GlobalSettings::get('mailuser'));
            $message->to(explode(';', GlobalSettings::get('mailcc')));
        });

        self::debug('Überprüfung Restzahlungen für ' . date('Y-m-d', time()) . ' abgeschlossen.');

        self::debug('Status ' . Fewo::var_dump_ret($status));
    }

    /**
     * @return array
     */
    private static function bearbeiteRestzahlungen($openPaymentsToHandle = null, string $actor = 'Automatik')
    {
        if ($openPaymentsToHandle === null) {
            $today = date('Y-m-d');
            $sql = "select za.*, bu.objektid as bu_objid from xsigns_fewo_zahlungen as za left join xsigns_fewo_buchung as bu on za_buid = bu.id where za_anz_gezahlt = 1 and za_restz_gezahlt = 0 and za_restz_am = :today";
            self::debug('Sql: ' . $sql);
            $zahlungen = Database::select(null, self::$modulname, $sql, false, ['today' => $today]);
        } else
            $zahlungen = $openPaymentsToHandle;
        
        self::debug('Anzahl: ' . count($zahlungen));

        $ergebnisse = [];

        if (count($zahlungen) > 0)
        {
            foreach ($zahlungen as $zahlung)
            {
                $hobexUrl = 'https://eu-prod.oppwa.com';
                if (GlobalSettings::get('hobextest') == 1)
                    $hobexUrl = 'https://eu-test.oppwa.com';

                $transactionId = RestPaymentAttempt::newTransactionId();
                $requestResult = self::payRequest($zahlung->za_restz_betrag, 'EUR', $transactionId, $hobexUrl, $zahlung->za_buid, 2, $zahlung->za_token, $zahlung->id, $actor);

                $vars = [
                    'BUCHUNG_ID' => $zahlung->za_buid,
                    'OBJEKT_ID' => $zahlung->bu_objid,
                    'ANZAHL_AM' => $zahlung->za_anz_am,
                    'ANZAHL_GEZAHLT_AM' => $zahlung->za_anz_gezahlt_am,
                    'ANZAHL_STATUS' => $zahlung->za_anz_gezahlt,
                    'ANZHAL_BETRAG' => $zahlung->za_anz_betrag,
                    'RESTZAHL_AM' => $zahlung->za_restz_am,
                    'RESTZAHL_BETRAG' => $zahlung->za_restz_betrag,
                    'GAST_NAME' => $zahlung->za_gast_name
                ];

                if ($requestResult === true)
                {
                    $vars['RESTZAHL_GEZAHLT_AM'] = date('Y-m-d', time());
                    $vars['RESTZAHL_STATUS'] = '1';
                    $vars['HINWEIS'] = 'Restzahlung erfolgreich durchgeführt';
                }
                else
                {
                    $vars['RESTZAHL_GEZAHLT_AM'] = null;
                    $vars['RESTZAHL_STATUS'] = 0;
                    $vars['HINWEIS'] = $requestResult;
                }

                $ergebnisse[] = $vars;
            }

            return $ergebnisse;
        }

        return $ergebnisse;
    }

    /**
     * @param $entityId
     * @param $accessToken
     * @param $restZahlBetrag
     * @param $currency
     * @param $tranactionId
     * @param $hobexUrl
     * @param $buid
     * @param $anRestZa
     * @param $cardToken
     * @param $zahlungId
     * @return bool|string
     */
    private static function payRequest($restZahlBetrag, $currency, $tranactionId, $hobexUrl, $buid, $anRestZa, $cardToken, $zahlungId, string $actor = 'Automatik')
    {
        if (!RestPaymentAttempt::reserve($zahlungId, $tranactionId, $actor)) {
            return 'Zahlung bereits verarbeitet oder in Prüfung; keine erneute Abbuchung.';
        }

        return self::payReserved($restZahlBetrag, $currency, $tranactionId, $hobexUrl, $buid, $anRestZa, $cardToken, $zahlungId);
    }

    public static function retryPayment(int $paymentId, string $actor): bool
    {
        $reconciled = (new RestPaymentReconciliation())->check($paymentId, $actor);
        if (!$reconciled || $reconciled['status'] !== 'failed') {
            return false;
        }
        $payment = DB::table('xsigns_fewo_zahlungen')->where('id', $paymentId)->first();
        $previous = DB::table('xsigns_fewo_rest_attempts')
            ->where('merchant_transaction_id', $payment->za_restz_receiptnumber)->first();
        $transactionId = RestPaymentAttempt::newTransactionId();
        if (!RestPaymentAttempt::retry($paymentId, $transactionId, $previous->checked_at, $actor)) {
            return false;
        }
        $host = GlobalSettings::get('hobextest') == 1 ? 'https://eu-test.oppwa.com' : 'https://eu-prod.oppwa.com';
        self::payReserved($payment->za_restz_betrag, 'EUR', $transactionId, $host,
            $payment->za_buid, 2, $payment->za_token, $paymentId);
        return true;
    }

    private static function payReserved($restZahlBetrag, $currency, $tranactionId, $hobexUrl, $buid, $anRestZa, $cardToken, $zahlungId)
    {
        $attempt = DB::table('xsigns_fewo_rest_attempts')->where('merchant_transaction_id', $tranactionId)->first();

        $hobex = new Hobex(GlobalSettings::get('hobextest'), GlobalSettings::get('hobexuserid'), GlobalSettings::get('hobexpassword'), GlobalSettings::get('hobexentityId'), GlobalSettings::get('hobexversion'), GlobalSettings::get('hobexaccesstoken'));
        $prepareCheckout = $hobex->prepareCheckout($restZahlBetrag, $currency, $tranactionId, $hobexUrl, $buid, $anRestZa, $cardToken);
        $checkoutArray = json_decode($prepareCheckout, true);
        $result = RestPaymentResult::evaluate([
            'result' => ['code' => '000.000.100'],
            'records' => is_array($checkoutArray) ? [$checkoutArray] : [],
        ], $attempt);
        self::debug('Hobex-Antwort zur Restzahlung; Versuch=' . $tranactionId . '; '
            . HobexLogContext::restPaymentResult($checkoutArray, $hobex->getLastHttpStatus(), $hobex->getLastTransportError())
            . '; Bewertung=' . $result['status'] . '; Grund=' . $result['message']);
        if (GlobalSettings::get('logHobex')) {
            HobexResponseLog::write('Hobex-Response zur Restzahlung; Versuch=' . $tranactionId, $checkoutArray);
        }
        if ($result['status'] === 'success')
        {
            DB::transaction(function () use ($zahlungId, $tranactionId, $result, $attempt) {
                $changed = DB::table('xsigns_fewo_zahlungen')->where('id', $zahlungId)
                    ->where('za_restz_receiptnumber', $tranactionId)->where('za_restz_gezahlt', 0)
                    ->update([
                        'za_restz_gezahlt' => 1,
                        'za_restz_gezahlt_am' => date('Y-m-d'),
                        'za_status' => $result['message'],
                        'za_restz_payid' => $result['paymentId'],
                    ]);
                if ($changed === 1) {
                    DB::table('xsigns_fewo_rest_attempts')->where('id', $attempt->id)->update([
                        'status' => 'success', 'message' => $result['message'],
                        'result_code' => $result['code'], 'provider_payment_id' => $result['paymentId'],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            });
            return true;
        }
        $message = ($checkoutArray['result']['code'] ?? '') === '200.100.103'
            ? 'Hobex hat den Zahlungsauftrag als strukturell ungültig abgelehnt (200.100.103); Wiederholung gesperrt.'
            : 'Providerergebnis prüfen; Wiederholung gesperrt.';
        DB::table('xsigns_fewo_rest_attempts')->where('id', $attempt->id)->update([
            'status' => 'unknown', 'message' => $message,
            'result_code' => (string) ($checkoutArray['result']['code'] ?? ''),
            'provider_payment_id' => (string) ($checkoutArray['id'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('xsigns_fewo_zahlungen')->where('id', $zahlungId)
            ->where('za_restz_receiptnumber', $tranactionId)->where('za_restz_gezahlt', 0)
            ->update(['za_status' => $message]);
        return $message;
    }

    /**
     * @param $message
     */
    private static function debug($message)
    {

        if (GlobalSettings::get('logHobex'))
            Logger::quickLog(self::$modulname, $message);
    }
}
