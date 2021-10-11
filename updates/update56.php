<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update56 extends Migration
{
    protected $modulename = 'update56';

    public function up()
    {
        Schema::table('xsigns_fewo_abrechnung', function ($table) {
            $table->integer('abr_eigenid')->unsigned()->default(0)->change();
            $table->integer('abr_monat')->unsigned()->default(1)->change();
            $table->integer('abr_jahr')->unsigned()->default(2021)->change();
            $table->string('abr_liste', 250)->default(' ')->change();
            $table->string('abr_provision', 250)->default(' ')->change();
            $table->integer('abr_download')->unsigned()->default(0)->change();
            $table->string('abr_art', 120)->default('G')->change();
            $table->date('abr_datum')->default('1001-01-01')->change();
            $table->text('abr_memo')->default(' ')->change();
            $table->text('abr_wartung')->default('[]')->change();
            $table->date('abr_datefrom')->default('1001-01-01')->change();
            $table->date('abr_dateto')->default('1001-01-01')->change();
            $table->string('abr_rechnr')->default(' ')->change();
            $table->decimal('abr_betrag', 5, 2)->default(0.00)->change();
            $table->decimal('abr_provbetrag', 5, 2)->default(0.00)->change();
        });

        Schema::table('xsigns_fewo_ang', function ($table) {
            $table->integer('ang_id')->unsigned()->default(0)->change();
            $table->string('ang_art', 100)->default('1')->change();
            $table->date('ang_von')->default('1001-01-01')->change();
            $table->date('ang_bis')->default('1001-01-01')->change();
            $table->integer('ang_tagebuchen')->unsigned()->default(1)->change();
            $table->integer('ang_aktiv')->unsigned()->default(0)->change();
            $table->integer('ang_erwachsene')->unsigned()->default(1)->change();
            $table->integer('ang_kinder')->unsigned()->default(0)->change();
            $table->integer('ang_mehrfach')->unsigned()->default(0)->change();
            $table->integer('ang_laenger')->unsigned()->default(0)->change();
            $table->string('ang_sort', 30)->default('0')->change();
            $table->integer('ang_tagevor')->unsigned()->default(0)->change();
            $table->integer('ang_tagevart')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_anglang', function ($table) {
            $table->integer('angid')->unsigned()->default(0)->change();
            $table->string('lang', 3)->default(' ')->change();
            $table->string('titel', 200)->default(' ')->change();
            $table->text('beschreibung')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_angobj', function ($table) {
            $table->integer('ango_angid')->unsigned()->default(0)->change();
            $table->integer('ango_objid')->unsigned()->default(0)->change();
            $table->date('ango_von')->default('1001-01-01')->change();
            $table->date('ango_bis')->default('1001-01-01')->change();
        });

        Schema::table('xsigns_fewo_art', function ($table) {
            $table->integer('artid')->unsigned()->default(0)->change();
            $table->string('art_kurz', 20)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_artlang', function ($table) {
            $table->integer('artlang_artid')->unsigned()->default(0)->change();
            $table->string('artlang_name', 100)->default(' ')->change();
            $table->string('artlang_lang', 3)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_ask', function ($table) {
            $table->date('ask_from')->default('1001-01-01')->change();
            $table->date('ask_to')->default('1001-01-01')->change();
        });

        Schema::table('xsigns_fewo_aus', function ($table) {
            $table->integer('ausid')->unsigned()->default(0)->change();
            $table->integer('aus_katid')->unsigned()->default(0)->change();
            $table->integer('aus_systemfileid')->unsigned()->default(0)->change();
            $table->string('aus_hash', 32)->default(' ')->change();
            $table->string('aus_diskname', 191)->default(' ')->change();
            $table->string('aus_filename', 191)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_auskat', function ($table) {
            $table->integer('auskatid')->unsigned()->default(0)->change();
            $table->string('auskat_sort', 10)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_auskatlang', function ($table) {
            $table->integer('auskat_katid')->unsigned()->default(0)->change();
            $table->string('auskat_name', 200)->default(' ')->change();
            $table->string('auskat_lang', 3)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_auslang', function ($table) {
            $table->integer('auslang_ausid')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_bew', function ($table) {
            $table->integer('obj_id')->unsigned()->default(0)->change();
            $table->integer('aktiv')->unsigned()->default(0)->change();
            $table->string('betreff', 250)->default(' ')->change();
            $table->text('nachricht')->default(' ')->change();
            $table->text('antwort')->default(' ')->change();
            $table->date('datum')->default('1001-01-01')->change();
            $table->string('mail', 250)->default(' ')->change();
            $table->string('gastname', 250)->default(' ')->change();
            $table->integer('pid')->unsigned()->default(0)->change();
            $table->string('ort', 200)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_bewopt', function ($table) {
            $table->integer('id')->unsigned()->default(0)->change();
            $table->string('titel', 120)->default(' ')->change();
            $table->string('sortindex', 191)->default(' ')->change();
            $table->string('lang', 3)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_bewoptlang', function ($table) {
            $table->integer('optionsid')->default(0)->change();
            $table->string('titel', 120)->default(' ')->change();
            $table->string('lang', 3)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_bewpunkte', function ($table) {
            $table->integer('bewertung_id')->unsigned()->default(0)->change();
            $table->integer('option_id')->unsigned()->default(0)->change();
            $table->integer('pid')->default(0)->change();
        });

        Schema::table('xsigns_fewo_buchung', function ($table) {
            $table->string('vtyp', 2)->default('B')->change();
            $table->date('erfasst')->default('1001-01-01')->change();
            $table->integer('objektid')->unsigned()->default(0)->change();
            $table->date('anreise')->default('1001-01-01')->change();
            $table->date('abreise')->default('1001-01-01')->change();
            $table->integer('erwachsene')->unsigned()->default(1)->change();
            $table->integer('kinder')->unsigned()->default(0)->change();
            $table->integer('kleinkinder')->unsigned()->default(0)->change();
            $table->text('leistungen')->default(' ')->change();
            $table->text('mitreisende')->default(' ')->change();
            $table->text('nachricht')->default(' ')->change();
            $table->string('nachricht', 250)->default(' ')->change();
            $table->integer('sync')->default(0)->change();
            $table->integer('userid')->unsigned()->default(0)->change();
            $table->integer('angebotid')->unsigned()->default(0)->change();
            $table->text('zuschlaege')->default(' ')->change();
            $table->text('versicherung')->default(' ')->change();
            $table->integer('gebuehr_ausanz')->unsigned()->default(0)->change();
            $table->date('pay_date')->default('1001-01-01')->change();
            $table->string('pay_id', 200)->default(' ')->change();
            $table->string('receiptnumber', 200)->default(' ')->change();
            $table->integer('synctofeondi')->default(0)->change();
            $table->integer('sync_timestamp')->default(0)->change();
        });

        Schema::table('xsigns_fewo_entf', function ($table) {
            $table->integer('id')->unsigned()->default(0)->change();
            $table->string('entf_strasse', 200)->default(' ')->change();
            $table->string('entf_ort', 200)->default(' ')->change();
            $table->string('entf_plz', 10)->default(' ')->change();
            $table->string('entf_land', 3)->default(' ')->change();
            $table->string('entf_lat', 60)->default(' ')->change();
            $table->string('entf_lng', 60)->default(' ')->change();
            $table->string('entf_url', 250)->default(' ')->change();
            $table->string('entf_sort', 20)->default(' ')->change();
            $table->string('entf_address', 250)->default(' ')->change();
            $table->string('entf_countrycode', 10)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_entflang', function ($table) {
            $table->integer('entfid')->unsigned()->default(0)->change();
            $table->string('lang', 3)->default(' ')->change();
            $table->string('name', 250)->default(' ')->change();
            $table->text('beschreibung')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_galleries', function ($table) {
            $table->string('name', 191)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_gast', function ($table) {
            $table->integer('gast_id')->unsigned()->default(0)->change();
            $table->string('gast_name', 120)->default(' ')->change();
            $table->string('gast_tel', 25)->default(' ')->change();
            $table->string('gast_mobil', 25)->default(' ')->change();
            $table->string('gast_mail', 250)->default(' ')->change();
            $table->integer('gast_gesperrt')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_ha', function ($table) {
            $table->integer('id')->unsigned()->default(0)->change();
            $table->string('haus_titel', 250)->default(' ')->change();
            $table->string('haus_name', 250)->default(' ')->change();
            $table->string('haus_alias', 250)->default(' ')->change();
            $table->string('haus_strasse', 250)->default(' ')->change();
            $table->string('haus_plz', 10)->default(' ')->change();
            $table->string('haus_land', 3)->default(' ')->change();
            $table->string('haus_ort', 250)->default(' ')->change();
            $table->string('haus_tel', 25)->default(' ')->change();
            $table->string('haus_fax', 25)->default(' ')->change();
            $table->string('haus_mail', 25)->default(' ')->change();
            $table->string('haus_lat', 60)->default(' ')->change();
            $table->string('haus_lng', 60)->default(' ')->change();
            $table->string('haus_sort', 20)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_halang', function ($table) {
            $table->integer('hausid')->unsigned()->default(0)->change();
            $table->string('lang', 3)->default(' ')->change();
            $table->string('name', 250)->default(' ')->change();
            $table->text('beschreibung')->default(' ')->change();
            $table->text('kurz')->default(' ')->change();
            $table->text('seo')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_imagelang', function ($table) {
            $table->string('imglang_objid', 4)->default(' ')->change();
            $table->string('imglang_lang', 3)->default(' ')->change();
            $table->string('imglang_titel', 160)->default(' ')->change();
            $table->text('imglang_html')->default(' ')->change();
            $table->string('imglang_html', 191)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_images', function ($table) {
            $table->integer('fewoid')->unsigned()->default(0)->change();
            $table->string('typ', 1)->default(' ')->change();
            $table->integer('no')->unsigned()->default(0)->change();
            $table->string('image', 250)->default(' ')->change();
            $table->string('title', 250)->default(' ')->change();
            $table->text('description')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_kunde', function ($table) {
            $table->string('firma', 160)->default(' ')->change();
            $table->string('vorname', 120)->default(' ')->change();
            $table->string('name', 120)->default(' ')->change();
            $table->string('str', 200)->default(' ')->change();
            $table->string('plz', 10)->default(' ')->change();
            $table->string('ort', 200)->default(' ')->change();
            $table->string('land', 3)->default(' ')->change();
            $table->string('tel', 25)->default(' ')->change();
            $table->string('fax', 25)->default(' ')->change();
            $table->string('mail', 160)->default(' ')->change();
            $table->string('bankinhaber', 200)->default(' ')->change();
            $table->string('bank', 200)->default(' ')->change();
            $table->string('steuernummer', 60)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_la', function ($table) {
            $table->integer('id')->unsigned()->default(0)->change();
            $table->string('sort', 10)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_lalang', function ($table) {
            $table->integer('lageid')->unsigned()->default(0)->change();
            $table->string('lang', 3)->default(' ')->change();
            $table->string('name', 250)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_le', function ($table) {
            $table->integer('leistid')->unsigned()->default(0)->change();
            $table->integer('leist_person')->unsigned()->default(0)->change();
            $table->integer('leist_artid')->unsigned()->default(0)->change();
            $table->integer('leist_tag')->unsigned()->default(0)->change();
            $table->integer('leist_anfrage')->unsigned()->default(0)->change();
            $table->integer('leist_sort')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_leart', function ($table) {
            $table->integer('leistart_id')->unsigned()->default(0)->change();
            $table->string('leistart_titel', 250)->default(' ')->change();
            $table->integer('leistart_aktiv')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_lelang', function ($table) {
            $table->integer('leistid')->unsigned()->default(0)->change();
            $table->string('lang', 3)->default(' ')->change();
            $table->text('beschreibung')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_messages', function ($table) {
            $table->string('title', 200)->default(' ')->change();
            $table->string('lang', 3)->default(' ')->change();
            $table->date('fromdate')->default('1001-01-01')->change();
            $table->date('todate')->default('1001-01-01')->change();
            $table->integer('active')->unsigned()->default(0)->change();
            $table->text('message')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_obj', function ($table) {
            $table->integer('id')->unsigned()->default(0)->change();
            $table->string('obj_alias', 250)->default(' ')->change();
            $table->string('obj_name', 200)->default(' ')->change();
            $table->integer('obj_verart')->unsigned()->default(0)->change();
            $table->string('obj_plz', 10)->default(' ')->change();
            $table->string('obj_land', 3)->default(' ')->change();
            $table->integer('obj_hausid')->unsigned()->default(0)->change();
            $table->time('obj_anreisevon')->default('00:00:00')->change();
            $table->time('obj_anreisebis')->default('00:00:00')->change();
            $table->time('obj_abreisevon')->default('00:00:00')->change();
            $table->time('obj_abreisebis')->default('00:00:00')->change();
            $table->string('obj_atraveo', 20)->default(' ')->change();
            $table->integer('obj_minalter')->unsigned()->default(0)->change();
            $table->decimal('obj_preismax', 12, 4)->default(0.00)->change();
            $table->decimal('obj_preismin', 12, 4)->default(0.00)->change();
            $table->date('obj_preisbis')->default('1001-01-01')->change();
            $table->integer('obj_preisanzahl')->default(0)->change();
            $table->decimal('obj_grundstuecksflaeche', 9, 2)->default(0.00)->change();
        });

        Schema::table('xsigns_fewo_objaus', function ($table) {
            $table->integer('objaus_objid')->unsigned()->default(0)->change();
            $table->integer('objaus_ausid')->unsigned()->default(0)->change();
            $table->string('objaus_wert', 40)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_objbleist', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->integer('leistid')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_objektbilder', function ($table) {
            $table->integer('obild_objid')->unsigned()->default(0)->change();
            $table->integer('obild_systemfileid')->unsigned()->default(0)->change();
            $table->string('obild_hash', 32)->default(' ')->change();
            $table->integer('obild_reihenfolge')->unsigned()->default(0)->change();
            $table->string('obild_titel', 160)->default(' ')->change();
            $table->string('obild_diskname', 191)->default(' ')->change();
            $table->string('obild_filename', 191)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_objentf', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->integer('entfid')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_objlagen', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->integer('lageid')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_objlang', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->string('titel', 200)->default(' ')->change();
            $table->string('titel2', 200)->default(' ')->change();
            $table->string('lang', 3)->default(' ')->change();
            $table->text('beschreibung')->default(' ')->change();
            $table->text('kurz')->default(' ')->change();
            $table->text('seo')->default(' ')->change();
            $table->text('lage')->default(' ')->change();
            $table->text('anfrage')->default(' ')->change();
            $table->text('preis1')->default(' ')->change();
            $table->text('preis2')->default(' ')->change();
            $table->text('baeder')->default(' ')->change();
            $table->text('schlafzimmer')->default(' ')->change();
            $table->text('html1')->default(' ')->change();
            $table->text('html2')->default(' ')->change();
            $table->text('html3')->default(' ')->change();
            $table->text('innen')->default(' ')->change();
            $table->text('aussen')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_objleist', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->integer('leistid')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_objstat', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_objza', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->integer('kautwann')->unsigned()->default(0)->change();
            $table->integer('anzaus')->unsigned()->default(0)->change();
            $table->integer('anztage')->unsigned()->default(0)->change();
            $table->integer('anzwann')->unsigned()->default(0)->change();
            $table->integer('resttage')->unsigned()->default(0)->change();
            $table->integer('restwann')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_orte', function ($table) {
            $table->string('ort_name', 250)->default(' ')->change();
            $table->string('ort_plz', 10)->default(' ')->change();
            $table->string('ort_land', 3)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_preise', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->date('von')->default('1001-01-01')->change();
            $table->date('bis')->default('1001-01-01')->change();
            $table->integer('personen')->unsigned()->default(1)->change();
            $table->integer('mintage')->unsigned()->default(0)->change();
            $table->integer('lueckenbok')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_preiselang', function ($table) {
            $table->integer('preislng_preisid')->unsigned()->default(0)->change();
            $table->integer('preislng_objid')->unsigned()->default(0)->change();
            $table->string('preislng_titel', 250)->default(' ')->change();
            $table->string('preislng_lang', 3)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_preisstatistik', function ($table) {
            $table->integer('pstat_objid')->unsigned()->default(0)->change();
            $table->decimal('pstat_preismax', 12, 4)->default(0.00)->change();
            $table->decimal('pstat_preismin', 12, 4)->default(0.00)->change();
            $table->date('pstat_preisbis')->default('1001-01-01')->change();
            $table->integer('pstat_anzahl')->default(0)->change();
        });

        Schema::table('xsigns_fewo_ralang', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->string('raumid', 4)->default(' ')->change();
            $table->string('lang', 3)->default(' ')->change();
            $table->string('titel', 160)->default(' ')->change();
            $table->text('beschreibung')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_raum', function ($table) {
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->string('raumid', 4)->default(' ')->change();
            $table->string('art', 1)->default(' ')->change();
            $table->text('ausst')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_reg', function ($table) {
            $table->integer('regionid')->unsigned()->default(0)->change();
            $table->string('region_name', 200)->default(' ')->change();
            $table->string('region_alias', 200)->default(' ')->change();
            $table->string('region_sort', 200)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_reglang', function ($table) {
            $table->integer('reglang_regionid')->unsigned()->default(0)->change();
            $table->string('reglang_lang', 3)->default(' ')->change();
            $table->string('reglang_name', 200)->default(' ')->change();
            $table->text('reglang_beschreibung')->default(' ')->change();
            $table->text('reglang_kurz')->default(' ')->change();
            $table->text('reglang_seo')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_reinfirma', function ($table) {
            $table->integer('rein_id')->unsigned()->default(0)->change();
            $table->string('rein_firma', 200)->default(' ')->change();
            $table->string('rein_name', 200)->default(' ')->change();
            $table->string('rein_mail', 250)->default(' ')->change();
            $table->string('rein_tel', 25)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_setaus', function ($table) {
            $table->string('name', 100)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_slide_shows', function ($table) {
            $table->string('slide_show_title', 191)->default(' ')->change();
            $table->text('slide_show_content')->default(' ')->change();
            $table->text('responsive')->default(' ')->change();
            $table->string('asimages_height', 10)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_typ', function ($table) {
            $table->integer('typid')->unsigned()->default(0)->change();
            $table->string('typen_name', 200)->default(' ')->change();
            $table->string('typen_sort', 10)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_typlang', function ($table) {
            $table->integer('typlang_typid')->unsigned()->default(0)->change();
            $table->string('typlang_lang', 3)->default(' ')->change();
            $table->string('typlang_name', 200)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_vorg', function ($table) {
            $table->integer('vorg_id')->unsigned()->default(0)->change();
            $table->integer('vorg_objid')->unsigned()->default(0)->change();
            $table->string('vorg_art', 4)->default('B')->change();
            $table->date('vorg_datum')->default('1001-01-01')->change();
            $table->date('vorg_anreise')->default('1001-01-01')->change();
            $table->date('vorg_abreise')->default('1001-01-01')->change();
            $table->string('vorg_vorname', 120)->default(' ')->change();
            $table->string('vorg_name', 120)->default(' ')->change();
            $table->string('vorg_mail', 250)->default(' ')->change();
            $table->integer('vorg_gastid')->unsigned()->default(0)->change();
            $table->integer('vorg_erw')->unsigned()->default(1)->change();
            $table->integer('vorg_kinder')->unsigned()->default(0)->change();
            $table->integer('vorg_kleinkind')->unsigned()->default(0)->change();
            $table->text('vorg_memo')->default(' ')->change();
            $table->text('vorg_ehinweis')->default(' ')->change();
            $table->integer('vorg_eigenid')->unsigned()->default(0)->change();
            $table->integer('vorg_reinigungid')->unsigned()->default(0)->change();
            $table->string('vorg_fremdart', 120)->default(' ')->change();
            $table->integer('vorg_fremdartid')->unsigned()->default(0)->change();
            $table->integer('vorg_is_b_bl_e')->unsigned()->default(0)->change();
            $table->integer('vorg_is_a_b_bl_e_o')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_vorggesendet', function ($table) {
            $table->integer('vorgid')->unsigned()->default(0)->change();
            $table->integer('bewertung')->unsigned()->default(0)->change();
            $table->integer('anschreiben')->unsigned()->default(0)->change();
            $table->string('vorgges_grundbew', 250)->default(' ')->change();
            $table->string('vorgges_grundanschr', 250)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_vorgleist', function ($table) {
            $table->integer('vorgid')->unsigned()->default(0)->change();
            $table->integer('leistid')->unsigned()->default(0)->change();
            $table->integer('objid')->unsigned()->default(0)->change();
            $table->text('text')->default(' ')->change();
        });

        Schema::table('xsigns_fewo_vorgmit', function ($table) {
            $table->integer('gastid')->unsigned()->default(0)->change();
            $table->integer('vorgid')->unsigned()->default(0)->change();
            $table->string('vorname', 30)->default(' ')->change();
            $table->string('name', 30)->default(' ')->change();
            $table->date('geb')->default('1001-01-01')->change();
        });

        Schema::table('xsigns_fewo_vorgzahl', function ($table) {
            $table->integer('vorgid')->unsigned()->default(0)->change();
            $table->string('art', 100)->default(' ')->change();
            $table->string('text', 220)->default(' ')->change();
            $table->date('datum')->default('1001-01-01')->change();
            $table->date('erfasst')->default('1001-01-01')->change();
        });

        Schema::table('xsigns_fewo_zahlungen', function ($table) {
            $table->integer('za_vorgid')->unsigned()->default(0)->change();
            $table->integer('za_buid')->unsigned()->default(0)->change();
            $table->decimal('za_anz_betrag', 8, 2)->default(0.00)->change();
            $table->date('za_anz_am')->default('1001-01-01')->change();
            $table->date('za_anz_gezahlt_am')->default('1001-01-01')->change();
            $table->decimal('za_anz_gezahlt', 8, 2)->default(0.00)->change();
            $table->decimal('za_restz_betrag', 8, 2)->default(0.00)->change();
            $table->date('za_restz_am')->default('1001-01-01')->change();
            $table->date('za_restz_gezahlt_am')->default('1001-01-01')->change();
            $table->decimal('za_restz_gezahlt', 8, 2)->default(0.00)->change();
            $table->string('za_token', 191)->default(' ')->change();
        });

        Schema::table('xsigns_fewo_zu', function ($table) {
            $table->integer('zu_id')->unsigned()->default(0)->change();
            $table->string('zu_name', 200)->default(' ')->change();
            $table->decimal('zu_preis', 7, 2)->default(0.00)->change();
            $table->integer('zu_tage')->unsigned()->default(0)->change();
            $table->integer('zu_abpers')->unsigned()->default(0)->change();
            $table->integer('zu_abpersan')->unsigned()->default(0)->change();
            $table->integer('zu_kurzbucher')->unsigned()->default(0)->change();
            $table->integer('zu_tageminus')->unsigned()->default(0)->change();
            $table->integer('zu_objartid')->unsigned()->default(0)->change();
            $table->date('zu_von')->default('1001-01-01')->change();
            $table->date('zu_bis')->default('1001-01-01')->change();
            $table->integer('zu_zeitraumaktiv')->unsigned()->default(0)->change();
        });

        Schema::table('xsigns_fewo_zulang', function ($table) {
            $table->integer('zulng_zuid')->unsigned()->default(0)->change();
            $table->string('zulng_lang', 3)->default(' ')->change();
            $table->string('zulng_name', 200)->default(' ')->change();
        });

        if (Schema::hasTable('xsigns_owner_user_groups'))
        {
            Schema::table('xsigns_owner_user_groups', function ($table) {
                $table->string('name', 191)->default(' ')->change();
            });
        }

        if (Schema::hasTable('xsigns_owner_users'))
        {
            Schema::table('xsigns_owner_users', function ($table) {
                $table->string('name', 250)->default(' ')->change();
                $table->string('city', 250)->default(' ')->change();
                $table->string('country', 3)->default(' ')->change();
                $table->string('email', 191)->default(' ')->change();
                $table->integer('eid')->unsigned()->default(0)->change();
                $table->string('password', 191)->default(' ')->change();
                $table->string('username', 191)->default(' ')->change();
            });
        }

        if (Schema::hasTable('xsigns_events'))
        {
            Schema::table('xsigns_events', function ($table) {
                $table->date('from')->default('1001-01-01')->change();
                $table->date('to')->default('1001-01-01')->change();
                $table->string('title', 250)->default(' ')->change();
                $table->text('short')->default(' ')->change();
                $table->string('alias', 250)->default(' ')->change();
            });
        }

        if (Schema::hasTable('xsigns_weather_day'))
        {
            Schema::table('xsigns_weather_day', function ($table) {
                $table->date('day')->default('1001-01-01')->change();
                $table->decimal('night', 7, 2)->unsigned()->default(0.00)->change();
                $table->string('deg', 50)->default(' ')->change();
                $table->text('description')->default(' ')->change();
            });
        }
    }

    public function down()
    {

    }
}
