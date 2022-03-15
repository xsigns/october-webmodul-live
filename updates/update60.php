<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update60 extends Migration
{
    protected $modulename = 'update60';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_abrechnung'))
        {
            Schema::table('xsigns_fewo_abrechnung', function ($table) {
                $table->decimal('abr_betrag', 10, 2)->default(0.00)->change();
                $table->decimal('abr_provbetrag', 10, 2)->default(0.00)->change();
            });

            Database::select(null, $this->modulename, "alter table xsigns_fewo_abrechnung " .
                "modify column abr_memo text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column abr_wartung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_anglang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_anglang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_bew'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_bew " .
                "modify column nachricht text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column antwort text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_buchung " .
                "modify column leistungen text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column mitreisende text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column nachricht text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column zuschlaege text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column typeof text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column versicherung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_entflang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_entflang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_halang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_halang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column kurz text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column seo text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_images'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_images " .
                "modify column description text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_lelang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_lelang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_messages'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_messages " .
                "modify column message text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_objlang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_objlang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column kurz text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column seo text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column lage text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column anfrage text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column preis1 text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column preis2 text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column baeder text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column schlafzimmer text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column html1 text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column html2 text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column html3 text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column innen text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column aussen text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_ralang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_ralang " .
                "modify column beschreibung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_raum'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_raum " .
                "modify column ausst text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_reglang'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_reglang " .
                "modify column reglang_beschreibung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column reglang_kurz text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column reglang_seo text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_setaus'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_setaus " .
                "modify column ausstattung text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_slide_shows'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_slide_shows " .
                "modify column slide_show_content text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column responsive text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_fewo_vorg'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_vorg " .
                "modify column vorg_memo text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, " .
                "modify column vorg_ehinweis text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");

            Schema::table('xsigns_fewo_vorg', function ($table) {
                $table->date('vorg_erfasst')->default('1001-01-01');
            });

            \Db::update("update xsigns_fewo_vorg set vorg_erfasst = vorg_datum");
        }

        if (Schema::hasTable('xsigns_fewo_vorgleist'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_fewo_vorgleist " .
                "modify column text text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }

        if (Schema::hasTable('xsigns_weather_day'))
        {
            Database::select(null, $this->modulename, "alter table xsigns_weather_day " .
                "modify column description text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_abrechnung'))
        {
            Schema::table('xsigns_fewo_abrechnung', function ($table)
            {
                $table->decimal('abr_betrag', 5, 2)->default(0.00)->change();
                $table->decimal('abr_provbetrag', 5, 2)->default(0.00)->change();
            });
        }
    }
}
