<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\Logger;

class Update59 extends Migration
{
    protected $modulename = 'update59';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_abrechnung'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_abrechnung " .
                "modify column abr_memo text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column abr_wartung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_anglang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_anglang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_bew'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_bew " .
                "modify column nachricht text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column antwort text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_buchung " .
                "modify column leistungen text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column mitreisende text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column nachricht text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column zuschlaege text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column versicherung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_entflang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_entflang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_halang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_halang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column kurz text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column seo text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_images'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_images " .
                "modify column description text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_lelang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_lelang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_messages'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_messages " .
                "modify column message text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_objlang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_objlang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column kurz text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column seo text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column lage text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column anfrage text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column preis1 text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column preis2 text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column baeder text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column schlafzimmer text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column html1 text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column html2 text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column html3 text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column innen text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column aussen text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_ralang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_ralang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_raum'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_raum " .
                "modify column ausst text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_reglang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_reglang " .
                "modify column reglang_beschreibung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column reglang_kurz text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column reglang_seo text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_setaus'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_setaus " .
                "modify column ausstattung text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_slide_shows'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_slide_shows " .
                "modify column slide_show_content text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column responsive text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_vorg'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_vorg " .
                "modify column vorg_memo text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' ', " .
                "modify column vorg_ehinweis text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_fewo_vorgleist'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_vorgleist " .
                "modify column text text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }

        if (Schema::hasTable('xsigns_weather_day'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_weather_day " .
                "modify column description text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ' '");
        }
    }

    public function down()
    {

    }
}
