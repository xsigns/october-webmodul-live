<?php

namespace Xsigns\Fewo\Classes;

use Illuminate\Support\Facades\DB;
use Xsigns\Fewo\Models\GlobalSettings;
use Mail;

class RestzahlungsManager
{
    private static $modulname = 'Restzahlungen';

    public static function checkRestzahlungen($openPaymentsToHandle = null)
    {
        self::debug('Überprüfung Restzahlungen für ' . date('Y-m-d', time()) . ' gestartet.');

        $status = array();
        $restzahlungen = self::bearbeiteRestzahlungen($openPaymentsToHandle);

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
    private static function bearbeiteRestzahlungen($openPaymentsToHandle = null)
    {
        if ($openPaymentsToHandle === null) {
            $today = date('Y-m-d');
            $sql = "select za.*, bu.objektid as bu_objid from xsigns_fewo_zahlungen as za left join xsigns_fewo_buchung as bu on za_buid = bu.id where za_anz_gezahlt = 1 and za_restz_gezahlt = 0 and za_restz_am = '" . $today . "'";
            self::debug('Sql: ' . $sql);
            $zahlungen = Database::select(null, self::$modulname, $sql);
        } else
            $zahlungen = $openPaymentsToHandle;
        
        self::debug('Anzahl: ' . count($zahlungen));

        $ergebnisse = [];

        if (count($zahlungen) > 0)
        {
            foreach ($zahlungen as $zahlung)
            {
                $hobexUrl = 'https://oppwa.com';
                if (GlobalSettings::get('hobextest') == 1)
                    $hobexUrl = 'https://eu-test.oppwa.com';

                $transactionId = str_pad($zahlung->bu_objid, 5, '0', STR_PAD_LEFT) . str_pad(mt_rand(1000, 9999), 5, '0', STR_PAD_LEFT);
                $requestResult = self::payRequest($zahlung->za_restz_betrag, 'EUR', $transactionId, $hobexUrl, $zahlung->za_buid, 2, $zahlung->za_token, $zahlung->id);

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
    private static function payRequest($restZahlBetrag, $currency, $tranactionId, $hobexUrl, $buid, $anRestZa, $cardToken, $zahlungId)
    {
        $hobex = new Hobex(GlobalSettings::get('hobextest'), GlobalSettings::get('hobexuserid'), GlobalSettings::get('hobexpassword'), GlobalSettings::get('hobexentityId'), GlobalSettings::get('hobexversion'), GlobalSettings::get('hobexaccesstoken'));
        $prepareCheckout = $hobex->prepareCheckout($restZahlBetrag, $currency, $tranactionId, $hobexUrl, $buid, $anRestZa, $cardToken);
        $checkoutArray = json_decode($prepareCheckout, true);

        if (GlobalSettings::get('logHobex'))
            Logger::quickLog(self::$modulname, 'Prepare checkout Restzahlung', $checkoutArray);

        $pruefeResultcode = preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $checkoutArray['result']['code']);

        if ($pruefeResultcode)
        {
            DB::update("update xsigns_fewo_zahlungen set za_restz_gezahlt = 1, za_restz_gezahlt_am = '". date('Y-m-d', time()) . "', za_status = 'Restzahlung erfolgreich durchgeführt' where id = " . $zahlungId);

            DB::table('xsigns_fewo_zahlungen')->where('id', '=', $zahlungId)->update([
                'za_restz_gezahlt' => 1,
                'za_restz_gezahlt_am' => date('Y-m-d', time()),
                'za_status' => 'Restzahlung erfolgreich durchgeführt',
                'za_restz_payid' => $checkoutArray['ndc'],
                'za_restz_receiptnumber' => $checkoutArray['merchantTransactionId'],
            ]);

            return true;
        }
        else
        {
            DB::update("update xsigns_fewo_zahlungen set za_restz_gezahlt = 0, za_status = '" . $checkoutArray['result']['description'] . "' where id = " . $zahlungId);
            return 'Fehler: ' . $checkoutArray['result']['description'];
        }
    }

    /**
     * @param $message
     */
    private static function debug($message)
    {
        if (isset($_GET['debug']) && $_GET['debug'] === 'Xsigns27356R0W')
            echo 'Restzahlungen: ' . $message . '</br></br>';

        if (GlobalSettings::get('logHobex'))
            Logger::quickLog(self::$modulname, $message);
    }
}