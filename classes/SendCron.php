<?php

namespace Xsigns\Fewo\Classes;

use DB;
use Config;
use RainLab\Translate\Classes\Translator;
use Xsigns\Fewo\Models\GlobalSettings;
use Mail;
use System\Models;
use Schema;

define ('MAILART_ANREISE', 0);
define ('MAILART_ABREISE', 1);

/**
 * Class SendCron
 * @package Xsigns\Fewo\Classes
 */
class SendCron
{
    protected static $modulename = 'sendcron';

    /**
     * @param $strString
     * @return string|string[]|null
     */
    public static function strip_insert_tags($strString)
    {
        $count = 0;

        do
        {
            $strString = preg_replace('/{{[^{}]*}}/', '', $strString, -1, $count);
        }
        while ($count > 0);

        return $strString;
    }

    /**
     * @param $strString
     * @param false $blnPreserveUppercase
     * @return string
     */
    public static function standardize($strString, bool $blnPreserveUppercase = false): string
    {
        $strString = str_replace(array("ü", "ä", "ö", "Ü", "Ä", "Ö", "ú", "é", "á", "í", "ó", "ù", "è", "à", "ì", "ò", "ß"), array('ue', 'ae', 'oe', 'ue', 'ae', 'oe', 'u', 'e', 'a', 'i', 'o', 'u', 'e', 'a', 'i', 'o', 'ss'), $strString);
        $arrSearch = array('/[^a-zA-Z0-9 \.\&\/_-]+/', '/[ \.\&\/-]+/');
        $arrReplace = array('', '-');
        $strString = html_entity_decode($strString, ENT_QUOTES);
        $strString = SendCron::strip_insert_tags($strString);
        $strString = preg_replace($arrSearch, $arrReplace, $strString);

        if (!$blnPreserveUppercase)
            $strString = strtolower($strString);

        return trim($strString, '-');
    }

    /**
     * @param $mailaddr
     * @param $vorgid
     * @param $gastid
     * @param $gastname
     * @param $mailTyp
     * @return bool|mixed
     */
    public static function checkMail($mailaddr/*, $vorgid, $gastid, $gastname, $mailTyp*/)
    {
        $ergebnis = false;
        $hinweis = "";

        if (@preg_match('/\b\S+?\@\S+\.\S+?\b/i', $mailaddr))
        {
            if (strpos($mailaddr, '@guest.booking.com') !== false)
                $hinweis = 'Die E-Mail-Adresse vom Gast ist fehlerhaft: Alias von booking.com enthalten';

            if (strpos($mailaddr, '@guest.airbnb.com') !== false)
                $hinweis = 'Die E-Mail-Adresse vom Gast ist fehlerhaft: Alias von Airbnb enthalten';

            $host = preg_replace('/^.+\@/i', '', $mailaddr);

            if (checkdnsrr($host) === false)
                $hinweis = 'Die E-Mail-Adresse vom Gast ist fehlerhaft: Host "' . $host . '" nicht gefunden';
            else
            {
                if (checkdnsrr($host, 'MX') === false)
                {
                    $hinweis = 'Die E-Mail-Adresse vom Gast ist fehlerhaft: MX-Record "' . $host . '" nicht vorhanden';
                    $ergebnis = false;
                }
                else
                    $ergebnis = true;
            }
        }
        else
        {
            $hinweis = '"' . $mailaddr . '" ist keine gültige E-Mail-Adresse, bitte korrigieren';
            $ergebnis = false;
        }

        return new CheckMailReturn($ergebnis, $hinweis);
    }

    /**
     * @throws \Exception
     */
    public static function Mails()
    {
        self::debug('Cron-Jobs', 'gestartet, Einstellungen: cronafter ' . GlobalSettings::get('cronafter') . ', afterdays: ' . GlobalSettings::get('afterdays') . ', cronbefore ' . GlobalSettings::get('cronbefore') . ', beforedays: ' . GlobalSettings::get('beforedays'));

        $status = array();

        if (GlobalSettings::get('cronbefore'))
        {
            $abreisemails = self::BearbeiteBereich(MAILART_ANREISE);
            $status[] = [
                'BEREICH' => 'Anreise-E-Mails',
                'STATUS' => $abreisemails->message,
                'VORGAENGE' => $abreisemails->ergebnisse
            ];
        }

        if (GlobalSettings::get('cronafter') && GlobalSettings::get('afterdays') > 0)
        {
            $abreisemails = self::BearbeiteBereich(MAILART_ABREISE);
            $status[] = [
                'BEREICH' => 'Abreise-E-Mails',
                'STATUS' => $abreisemails->message,
                'VORGAENGE' => $abreisemails->ergebnisse
            ];
        }

        $statusberichte = [
            'STATUSBERICHTE' => $status
        ];

        if (GlobalSettings::get('cronstatus'))
        {
            try
            {
                Mail::send('xsigns.fewo::mail.cronstatus', $statusberichte, function ($message)
                {
                    $message->from(GlobalSettings::get('mailaddress'), GlobalSettings::get('mailuser'));
                    $message->to(explode(';', GlobalSettings::get('mailcc')));
                });
            }
            catch (\Exception $exception)
            {
                Logger::quickLog(self::$modulename, 'Status-E-Mail konnte nicht an CC E-Mailadresse versendet werden: ', $exception->getMessage());
            }
        }

        self::debug('Cron-Jobs', Fewo::var_dump_ret($statusberichte));
    }

    private static function BearbeiteBereich(int $mailart): BearbeiteBereichReturn
    {
        $start = time();
        $datum = date("Y-m-d", $start);

        $isTranslate = DB::select("select code from system_plugin_versions where code = 'RainLab.Translate'");
        $mailTemps = Models\MailTemplate::listAllTemplates();

        if ($mailart == MAILART_ANREISE)
        {
            $bereich = 'Cron Anreise-E-Mail';
            $dayvariable = 'beforedays';
            $activevariable = 'cronbefore';

            if (GlobalSettings::get($dayvariable) > 0)
                $datumberechnet = date('Y-m-d', strtotime($datum . ' + ' . GlobalSettings::get($dayvariable) . ' days'));
            else
                $datumberechnet = date('Y-m-d', strtotime($datum . ' ' . GlobalSettings::get($dayvariable) . ' days'));

            $wherepart = " and vorg_anreise = '" . $datumberechnet . "'";
            $mailview = 'xsigns.fewo::mail.before_';
        }
        elseif ($mailart == MAILART_ABREISE)
        {
            $bereich = 'Cron Abreise-E-Mail';
            $dayvariable = 'afterdays';
            $activevariable = 'cronafter';
            $datumberechnet = date('Y-m-d', strtotime($datum . ' - ' . GlobalSettings::get($dayvariable) . ' days'));
            $wherepart = " and vorg_abreise = '" . $datumberechnet . "'";
            $mailview = 'xsigns.fewo::mail.voting_';
        }
        else
            return new BearbeiteBereichReturn('keine gültige Mailart', []);

        $message = 'gestartet am ' . date("d.m.Y", $start) . ' um ' . date("H:i:s (P)", $start) . ' Uhr mit folgenden Einstellungen: aktiv -> ' . GlobalSettings::get($activevariable) . ', Tage -> ' . GlobalSettings::get($dayvariable) . ', Datum berechnet -> ' . $datumberechnet;

        self::debug($bereich, $message);

        $sql = "select vorg_id, vorg_objid, vorg_gastid, vorg_anreise, vorg_abreise, vorg_kinder, vorg_erw, vorg_kleinkind, xsigns_fewo_vorggesendet.id as vorgges_id, anschreiben, bewertung, xsigns_fewo_obj.id as obj_id, obj_alias, obj_strasse, obj_plz, obj_ort, obj_land, obj_regionid, titel, beschreibung, gast_titel, gast_anrede, gast_name, gast_vorname, gast_gesperrt, gast_werbemail, gast_mail from xsigns_fewo_vorg left join xsigns_fewo_vorggesendet on vorg_id = vorgid right join xsigns_fewo_obj on xsigns_fewo_obj.id = vorg_objid left join xsigns_fewo_objlang on xsigns_fewo_objlang.objid = xsigns_fewo_obj.id and lang = 'DE' left join xsigns_fewo_gast on gast_id = vorg_gastid where vorg_art = 'B'" . $wherepart;

        $vorgaenge = Database::select(null, self::$modulename, $sql);

        self::debug($bereich, 'SQL: ' . $sql);
        self::debug($bereich, 'Anzahl: ' . count($vorgaenge));

        $ergebnisse = array();

        if (count($isTranslate) > 0)
        {
            $arrLocales = array();

            if (Schema::hasTable('rainlab_translate_locales'))
                $resLocales = Database::select(null,  self::$modulename, "select code as locale from rainlab_translate_locales");
            else
                $resLocales = Database::select(null, self::$modulename, 'select locale from system_site_definitions');

            foreach ($resLocales as $item)
                $arrLocales[] = $item->locale;
        }

        foreach ($vorgaenge as $vorgang)
        {
            if ($vorgang->vorgges_id === null)
                Database::insert(null, self::$modulename,"xsigns_fewo_vorggesendet", ['vorgid' => $vorgang->vorg_id, 'anschreiben' => 0, 'bewertung' => 0]);

            $gastLand = 'de';
            $gast =  Database::select(null, self::$modulename, "select * from xsigns_fewo_gast where gast_id = " . $vorgang->vorg_gastid);

            if (count($gast) > 0)
                $gastLand = $gast[0]->gast_land;

            if ($gastLand == 'GB' || $gastLand == 'gb')
                $gastLand = 'en';

            $mailBereitsGesendet = $vorgang->bewertung == 1;

            if ($mailart == MAILART_ANREISE)
                $mailBereitsGesendet = $vorgang->anschreiben == 1;

            $url = GlobalSettings::get('objektpath');

            if (count($isTranslate) > 0 && $gastLand != 'DE' && $gastLand != 'de')
            {
                if(in_array(strtolower($gastLand), $arrLocales) && array_key_exists($mailview . strtolower($gastLand), $mailTemps))
                    $url = Fewo::getTranslate(strtolower($gastLand), $url);
            }

            $href = str_replace(':alias', $vorgang->obj_alias, $url);
            $href = str_replace(':ort', SendCron::standardize($vorgang->obj_ort), $href);

            if (strpos($href, ':region') > 0)
            {
                $region = Region::bildeRegionstext(null, self::$modulename, $vorgang->obj_regionid, 'DE');
                $href = str_replace(':region', SendCron::standardize($region), $href);
            }

            if (count($isTranslate) > 0 && $gastLand != 'DE' && $gastLand != 'de')
            {
                $settings = GlobalSettings::first();
                $linkText = $settings->getAttributeTranslated('linktext', strtolower($gastLand));
            }
            else
                $linkText = GlobalSettings::get('linktext');

            $appUrl = Config::get('app.url');

            if (substr($appUrl, -1) == '/')
                $appUrl = rtrim($appUrl, '/');

            $bewLink = '<a href="' . $appUrl . $href . '">' . $linkText . '</a>';

            $vars = [
                'VORGANG_ID' => $vorgang->vorg_id,
                'OBJEKT_ID' => $vorgang->vorg_objid,
                'OBJEKT' => $vorgang->titel,
                'OBJEKT_ALIAS' => $vorgang->obj_alias,
                'OBJEKT_NR' => $vorgang->obj_id,
                'OBJEKT_STRASSE' => $vorgang->obj_strasse,
                'OBJEKT_PLZ' => $vorgang->obj_plz,
                'OBJEKT_ORT' => $vorgang->obj_ort,
                'OBEKT_BESCHREIBUNG' => $vorgang->beschreibung,
                'OBJEKT_LAND' => $vorgang->obj_land,
                'BEWLINK' => $bewLink,
                'ANREISE' => date("d.m.Y", strtotime($vorgang->vorg_anreise)),
                'ABREISE' => date("d.m.Y", strtotime($vorgang->vorg_abreise)),
                'TITEL' => $vorgang->gast_titel,
                'ANREDE' => $vorgang->gast_anrede,
                'VORNAME' => $vorgang->gast_vorname,
                'NAME' => $vorgang->gast_name,
                'EMAIL' => $vorgang->gast_mail,
                'GESPERRT' => $vorgang->gast_gesperrt == 1 ? 'ja' : 'nein',
                'WERBEMAIL' => $vorgang->gast_werbemail == 1 ? 'ja' : 'nein',
                'KINDER' => $vorgang->vorg_kinder,
                'ERWACHSENE' => $vorgang->vorg_erw,
                'KLEINKINDER' => $vorgang->vorg_kleinkind,
                'TAGE' => Fewo::DaysBetween($vorgang->vorg_anreise, $vorgang->vorg_abreise),
            ];

            if (!$mailBereitsGesendet && date("Y", strtotime($vorgang->vorg_anreise)) > 2020)
            {
                $values = [];

                if ($vorgang->gast_mail === '')
                    $hinweis = 'Gast-E-Mailadresse ist leer';
                else if ($vorgang->gast_gesperrt == 1)
                    $hinweis = 'Gast ist gesperrt, keine E-Mail gesendet';
                else if ($vorgang->gast_werbemail == 0 && (($mailart == MAILART_ANREISE && GlobalSettings::get('cronBeforeDefaultOn') == 0) || ($mailart == MAILART_ABREISE && GlobalSettings::get('cronAfterDefaultOn') == 0)))
                    $hinweis = 'Gast möchte keine Werbemail, keine E-Mail gesendet';
                else
                {
                    $checkmailSuccessful = SendCron::checkMail($vorgang->gast_mail);
                    if ($checkmailSuccessful->ergebnis)
                    {
                        try
                        {
                            if (count($isTranslate) > 0 && array_key_exists($mailview . strtolower($gastLand), $mailTemps))
                                $mailviewSend = $mailview . strtolower($gastLand);
                            else
                                $mailviewSend = $mailview . 'de';

                            $gastmail = $vorgang->gast_mail;

                            Mail::send($mailviewSend, $vars, function ($message) use ($gastmail) {
                                $message->from(GlobalSettings::get('mailaddress'), GlobalSettings::get('mailuser'));

                                if (GlobalSettings::get('mailcccron'))
                                    $message->to($gastmail)->cc(explode(';', GlobalSettings::get('mailcc')));
                                else
                                    $message->to($gastmail);
                            });

                            $hinweis = 'E-Mail erfolgreich gesendet';

                            if ($mailart == MAILART_ANREISE)
                                $values['anschreiben'] = 1;
                            else
                                $values['bewertung'] = 1;
                        }
                        catch (\Exception $exception)
                        {
                            $hinweis = $exception->getMessage();
                        }
                    }
                    else
                        $hinweis = $checkmailSuccessful->hinweis;
                }

                if ($mailart == MAILART_ANREISE)
                    $values['vorgges_grundanschr'] = $hinweis;
                else
                    $values['vorgges_grundbew'] = $hinweis;

                Database::update(null, self::$modulename, "xsigns_fewo_vorggesendet", $values, "where vorgid = '" . $vorgang->vorg_id . "'");

                $vars['HINWEIS'] = $hinweis;
            }
            else
                $vars['HINWEIS'] = 'Vorgang bereits zuvor geprüft';

            $ergebnisse[] = $vars;
        }

        return new BearbeiteBereichReturn($message, $ergebnisse);
    }

    private static function debug($bereich, $message, $brAtEnd = true)
    {
        if (isset($_GET['debug']) && $_GET['debug'] === 'Xsigns27356R0W')
            echo $bereich . ': ' . $message . ($brAtEnd ? '<br><br>' : '');

        if (GlobalSettings::get('cronlog'))
            Models\EventLog::add($bereich . ': ' . $message);
    }
}

class CheckMailReturn
{
    public $hinweis = '';
    public $ergebnis = false;

    public function __construct($ergebnis, $hinweis = '')
    {
        $this->ergebnis = $ergebnis;
        $this->hinweis = $hinweis;
    }
}

class BearbeiteBereichReturn
{
    public $message = '';
    public $ergebnisse = [];

    public function __construct($message, $ergebnisse)
    {
        $this->ergebnisse = $ergebnisse;
        $this->message = $message;
    }
}