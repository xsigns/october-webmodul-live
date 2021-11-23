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
            Schema::table('xsigns_fewo_abrechnung', function ($table) {
                $table->text('abr_memo')->default('')->change();
                $table->text('abr_wartung')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_anglang'))
        {
            Schema::table('xsigns_fewo_anglang', function ($table) {
                $table->text('beschreibung')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_bew'))
        {
            Schema::table('xsigns_fewo_bew', function ($table) {
                $table->text('nachricht')->default('')->change();
                $table->text('antwort')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Schema::table('xsigns_fewo_buchung', function ($table) {
                $table->text('leistungen')->default('')->change();
                $table->text('mitreisende')->default('')->change();
                $table->text('nachricht')->default('')->change();
                $table->text('zuschlaege')->default('')->change();
                $table->text('versicherung')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_entflang'))
        {
            Schema::table('xsigns_fewo_entflang', function ($table) {
                $table->text('beschreibung')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_halang'))
        {
            Schema::table('xsigns_fewo_halang', function ($table) {
                $table->text('beschreibung')->default('')->change();
                $table->text('kurz')->default('')->change();
                $table->text('seo')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_images'))
        {
            Schema::table('xsigns_fewo_images', function ($table) {
                $table->text('description')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_lelang'))
        {
            Schema::table('xsigns_fewo_lelang', function ($table) {
                $table->text('beschreibung')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_messages'))
        {
            Schema::table('xsigns_fewo_messages', function ($table) {
                $table->text('message')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_objlang'))
        {
            Schema::table('xsigns_fewo_objlang', function ($table) {
                $table->text('beschreibung')->default('')->change();
                $table->text('kurz')->default('')->change();
                $table->text('seo')->default('')->change();
                $table->text('lage')->default('')->change();
                $table->text('anfrage')->default('')->change();
                $table->text('preis1')->default('')->change();
                $table->text('preis2')->default('')->change();
                $table->text('baeder')->default('')->change();
                $table->text('schlafzimmer')->default('')->change();
                $table->text('html1')->default('')->change();
                $table->text('html2')->default('')->change();
                $table->text('html3')->default('')->change();
                $table->text('innen')->default('')->change();
                $table->text('aussen')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_ralang'))
        {
            Schema::table('xsigns_fewo_ralang', function ($table) {
                $table->text('beschreibung')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_raum'))
        {
            Schema::table('xsigns_fewo_raum', function ($table) {
                $table->text('ausst')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_reglang'))
        {
            Schema::table('xsigns_fewo_reglang', function ($table) {
                $table->text('reglang_beschreibung')->default('')->change();
                $table->text('reglang_kurz')->default('')->change();
                $table->text('reglang_seo')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_setaus'))
        {
            Schema::table('xsigns_fewo_setaus', function ($table) {
                $table->text('ausstattung')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_slide_shows'))
        {
            Schema::table('xsigns_fewo_slide_shows', function ($table) {
                $table->text('slide_show_content')->default('')->change();
                $table->text('responsive')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_vorg'))
        {
            Schema::table('xsigns_fewo_vorg', function ($table) {
                $table->text('vorg_memo')->default('')->change();
                $table->text('vorg_ehinweis')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_vorgleist'))
        {
            Schema::table('xsigns_fewo_vorgleist', function ($table) {
                $table->text('text')->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_weather_day'))
        {
            Schema::table('xsigns_weather_day', function ($table) {
                $table->text('description')->default('')->change();
            });
        }
    }

    public function down()
    {

    }
}
