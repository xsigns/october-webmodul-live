<?php namespace Xsigns\Fewo\Classes;

use DB;
use Config;
use Xsigns\Fewo\Models\GlobalSettings;
use Mail;
use System\Models;

/**
 * Class SendCron
 * @package Xsigns\Fewo\Classes
 */
class SendCron
{
    public static $gastmail;

    protected static $modulename = 'sendcron';

    public static function NewsLetter() {}

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
    public static function standardize($strString, $blnPreserveUppercase = false)
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
     * @return bool|mixed
     */
    public static function checkMail($mailaddr, $vorgid, $gastid, $gastname)
    {
        $return = false;
        $hinweis = "";

        if (@preg_match('/\b\S+?\@\S+\.\S+?\b/i', $mailaddr))
        {
            if (strpos($mailaddr, "@guest.booking.com") !== false)
                $hinweis = "Cron : Vorgang " . $vorgid . ". Mail-Adresse vom Gast fehlerhaft! Alias von booking.com enthalten";

            if (strpos($mailaddr, "@guest.airbnb.com") !== false)
                $hinweis = "Cron : Vorgang " . $vorgid . ". Mail-Adresse vom Gast fehlerhaft! Alias von Airbnb vorhanden";

            $host = preg_replace('/^.+\@/i', '', $mailaddr);

            if (checkdnsrr($host) === false)
                $hinweis = " Cron : Vorgang " . $vorgid . ". Mail-Adresse vom Gast Host nicht gefunden!";
            else
            {
                if (checkdnsrr($host, 'MX') === false)
                {
                    $hinweis = "Cron : Vorgang " . $vorgid . ". Mail-Adresse vom Gast MX nicht vorhanden!";
                    $return = false;
                }
                else
                    $return = true;
            }
        }
        else
        {
            $hinweis = "Keine gültige Mail-Adresse";
            $return = false;
        }

        if ($return === false)
        {
            $mailview = 'xsigns.fewo::mail.mailerror';

            $vars = [
                'gastnr' => $gastid,
                'gastname' => $gastname,
                'gastmail' => $mailaddr,
                'hinweis' => $hinweis
            ];

            Mail::send($mailview, $vars, function($message)
            {
                $message->from(GlobalSettings::get('mailaddress'), GlobalSettings::get('mailuser'));
                $message->to(GlobalSettings::get('mailaddress'));
            });

            $arrInsert = array();
            $arrInsert['vorgid'] = $vorgid;
            $arrInsert['bewertung'] = '1';
            DB::table('xsigns_fewo_vorggesendet')->insert($arrInsert);
        }

        return $return;
    }

    public static function Mails()
    {
        if (GlobalSettings::get('cronafter') == true && GlobalSettings::get('afterdays') > 0)
        {
            if (GlobalSettings::get('cronlog'))
                Models\EventLog::add('Cron Bewertung gestartet ' . date("d.m.Y h:i:s", time()));

            $datum = date("Y-m-d", time());
            $bewzaehler = 0;
            $Date = date("Y-m-d", time());
            $datemax = date('Y-m-d', strtotime($Date . ' - ' . GlobalSettings::get('afterdays') . ' days'));
            $sql = "select * from xsigns_fewo_vorg where date_add(vorg_abreise, interval " . GlobalSettings::get('afterdays') . " day) <= '" . $datum . "' and vorg_abreise >= '" . $datemax . "' and vorg_art = 'B'";
            $res = Database::select(null, self::$modulename, $sql);
            $gesendet = 0;

            if (count($res) > 0)
            {
                foreach ($res as $item)
                {
                    $mSenden = false;
                    $resMail = Database::select(null, self::$modulename,"select * from xsigns_fewo_vorggesendet where vorgid=" . $item->vorg_id);

                    if (count($resMail) > 0 && $resMail[0]->bewertung < 1)
                        $mSenden = true;
                    if (count($resMail) < 1)
                        $mSenden = true;

                    $resObjekt = Database::select(null, self::$modulename, "select t1.*, t2.* from xsigns_fewo_obj as t1 left join xsigns_fewo_objlang as t2 on (t2.objid=t1.id) and t2.lang = 'DE' where t1.id = " . $item->vorg_objid);
                    $resGast = Database::select(null, self::$modulename, "select gast_titel, gast_anrede, gast_name, gast_vorname, gast_gesperrt, gast_mail from xsigns_fewo_gast where gast_id = " . $item->vorg_gastid . " and gast_werbemail = 1");

                    if (count($resGast) > 0)
                    {
                        if ($resGast[0]->gast_mail && $mSenden == true && date("Y", strtotime($item->vorg_anreise)) > 2017 && SendCron::checkMail($resGast[0]->gast_mail, $item->vorg_id, $item->vorg_gastid, $resGast[0]->gast_name) == true)
                        {
                            $mailview = 'xsigns.fewo::mail.voting_de';
                            $myBase = dirname($_SERVER['PHP_SELF']);

                            if ($myBase == '/')
                                $myBase = "";

                            $href = str_replace(':alias', $resObjekt[0]->obj_alias, GlobalSettings::get('objektpath'));
                            $href = str_replace(':ort', SendCron::standardize($resObjekt[0]->obj_ort), $href);

                            if (strpos($href, ':region') > 0)
                            {
                                $region = Region::bildeRegionstext(null, self::$modulename, $resObjekt[0]->obj_regionid, 'DE');
                                $href = str_replace(':region', SendCron::standardize($region), $href);
                            }

                            $bewLink = '<a href="' . Config::get('app.url') . $href . '">' . GlobalSettings::get('linktext') . '</a>';

                            $vars = [
                                'OBJEKT' => $resObjekt[0]->titel,
                                'OBJEKT_ALIAS' => $resObjekt[0]->obj_alias,
                                'OBJEKT_NR' => $resObjekt[0]->id,
                                'OBJEKT_STRASSE' => $resObjekt[0]->obj_strasse,
                                'OBJEKT_PLZ' => $resObjekt[0]->obj_plz,
                                'OBJEKT_ORT' => $resObjekt[0]->obj_ort,
                                'OBEKT_BESCHREIBUNG' => $resObjekt[0]->beschreibung,
                                'OBJEKT_LAND' => $resObjekt[0]->obj_land,
                                'BEWLINK' => $bewLink,
                                'ANREISE' => date("d.m.Y", strtotime($item->vorg_anreise)),
                                'ABREISE' => date("d.m.Y", strtotime($item->vorg_abreise)),
                                'TITEL' => $resGast[0]->gast_titel,
                                'ANREDE' => $resGast[0]->gast_anrede,
                                'VORNAME' => $resGast[0]->gast_vorname,
                                'NAME' => $resGast[0]->gast_name,
                                'KINDER' => $item->vorg_kinder,
                                'ERWACHSENE' => $item->vorg_erw,
                                'KLEINKINDER' => $item->vorg_kleinkind,
                                'TAGE' => Fewo::DaysBetween($item->vorg_anreise, $item->vorg_abreise)
                            ];

                            self::$gastmail = $resGast[0]->gast_mail;

                            if ($resGast[0]->gast_gesperrt < 1)
                            {
                                if (GlobalSettings::get('mailcccron'))
                                {
                                    Mail::send($mailview, $vars, function($message)
                                    {
                                        $message->from(GlobalSettings::get('mailaddress'), GlobalSettings::get('mailuser'));
                                        $message->to(self::$gastmail)->cc(explode(";", GlobalSettings::get('mailcc')));
                                    });
                                }
                                else
                                {
                                    Mail::send($mailview, $vars, function($message)
                                    {
                                        $message->from(GlobalSettings::get('mailaddress'), GlobalSettings::get('mailuser'));
                                        $message->to(self::$gastmail);
                                    });
                                }
                                $gesendet += 1;
                            }

                            if (count($resMail) > 0)
                                DB::table('xsigns_fewo_vorggesendet')->where('vorgid', '=', $item->vorg_id)->update(['bewertung' => 1]);
                            //DB::select("update xsigns_fewo_vorggesendet set bewertung=1 where vorgid=" . $item->vorg_id);
                            else
                            {
                                $arrInsert = array();
                                $arrInsert['vorgid'] = $item->vorg_id;
                                $arrInsert['bewertung'] = '1';
                                DB::table('xsigns_fewo_vorggesendet')->insert($arrInsert);
                                //DB::select("insert into xsigns_fewo_vorggesendet (vorgid,bewertung) values('" . $item->vorg_id . "','1')");
                            }
                        }
                    }
                }

                if (GlobalSettings::get('cronlog'))
                    Models\EventLog::add("Cron-After : " . $gesendet . " send");
            }
        }

        if (GlobalSettings::get('cronbefore') == true && GlobalSettings::get('beforedays') > 0)
        {
            if (GlobalSettings::get('cronlog'))
                Models\EventLog::add('Cron Anreise gestartet ' . date("d.m.Y h:i:s", time()));

            $datumberechnet = strtotime(date("Y-m-d", time()) . "+" . GlobalSettings::get('beforedays') . " days");
            $resHinweis = Database::select(null, self::$modulename, "select * from xsigns_fewo_vorg where vorg_anreise = '" . date("Y-m-d", $datumberechnet) . "' and vorg_art = 'B'");

            if (count($resHinweis) > 0)
            {
                $gesendet = 0;

                foreach ($resHinweis as $item)
                {
                    $mSenden = false;
                    $resMail = Database::select(null, self::$modulename, "select * from xsigns_fewo_vorggesendet where vorgid = " . $item->vorg_id);

                    if (count($resMail) > 0 && $resMail[0]->anschreiben < 1) // Ist ein Treffer
                        $mSenden = true;
                    if (count($resMail) < 1)
                        $mSenden = true;

                    $resObjekt = Database::select(null, self::$modulename, "select t1.*, t2.* from xsigns_fewo_obj as t1 left join xsigns_fewo_objlang as t2 on (t2.objid = t1.id) where t1.id = " . $item->vorg_objid . " and t2.lang = 'DE'");
                    $resGast = Database::select(null, self::$modulename, "select gast_titel, gast_anrede, gast_name, gast_vorname, gast_gesperrt, gast_mail from xsigns_fewo_gast where gast_id = " . $item->vorg_gastid . " and gast_werbemail = 1");

                    if (count($resGast) > 0)
                    {
                        if ($resGast[0]->gast_mail && $mSenden == true && date("Y", strtotime($item->vorg_anreise)) > 2017 && SendCron::checkMail($resGast[0]->gast_mail, $item->vorg_id, $item->vorg_gastid, $resGast[0]->gast_name) == true)
                        {
                            self::$gastmail = $resGast[0]->gast_mail;

                            $mailview = 'xsigns.fewo::mail.before_de';
                            $vars = [
                                'OBJEKT' => $resObjekt[0]->titel,
                                'OBJEKT_ALIAS' => $resObjekt[0]->obj_alias,
                                'OBJEKT_NR' => $resObjekt[0]->id,
                                'OBJEKT_STRASSE' => $resObjekt[0]->obj_strasse,
                                'OBJEKT_PLZ' => $resObjekt[0]->obj_plz,
                                'OBJEKT_ORT' => $resObjekt[0]->obj_ort,
                                'OBEKT_BESCHREIBUNG' => $resObjekt[0]->beschreibung,
                                'OBJEKT_LAND' => $resObjekt[0]->obj_land,
                                'ANREISE' => date("d.m.Y", strtotime($item->vorg_anreise)),
                                'ABREISE' => date("d.m.Y", strtotime($item->vorg_abreise)),
                                'TITEL' => $resGast[0]->gast_titel,
                                'ANREDE' => $resGast[0]->gast_anrede,
                                'VORNAME' => $resGast[0]->gast_vorname,
                                'NAME' => $resGast[0]->gast_name,
                                'KINDER' => $item->vorg_kinder,
                                'ERWACHSENE' => $item->vorg_erw,
                                'KLEINKINDER' => $item->vorg_kleinkind,
                                'TAGE' => Fewo::DaysBetween($item->vorg_anreise, $item->vorg_abreise)
                            ];

                            if ($resGast[0]->gast_gesperrt < 1)
                            {
                                if (GlobalSettings::get('mailcccron'))
                                {
                                    Mail::send($mailview, $vars, function($message)
                                    {
                                        $message->from(GlobalSettings::get('mailaddress'), GlobalSettings::get('mailuser'));
                                        $message->to(self::$gastmail)->cc(explode(";", GlobalSettings::get('mailcc')));
                                    });
                                }
                                else
                                {
                                    Mail::send($mailview, $vars, function($message)
                                    {
                                        $message->from(GlobalSettings::get('mailaddress'), GlobalSettings::get('mailuser'));
                                        $message->to(self::$gastmail);
                                    });
                                }

                                $gesendet += 1;
                            }

                            if (count($resMail) > 0)
                                DB::table('xsigns_fewo_vorggesendet')->where('vorgid', '=', $item->vorg_id)->update(['anschreiben' => 1]);
                            //DB::select("update xsigns_fewo_vorggesendet set anschreiben=1 where vorgid=" .$item->vorg_id);
                            else
                            {
                                $arrInsert = array();
                                $arrInsert['vorgid'] = $item->vorg_id;
                                $arrInsert['anschreiben'] = '1';
                                DB::table('xsigns_fewo_vorggesendet')->insert($arrInsert);
                                //DB::select("insert into xsigns_fewo_vorggesendet (vorgid,anschreiben) values('" . $item->vorg_id . "','1')");
                            }
                        }
                    }
                }
                if (GlobalSettings::get('cronlog'))
                    Models\EventLog::add("Cron-Before : " . $gesendet . " send");
            }
        }
    }
}
