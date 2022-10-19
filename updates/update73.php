<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update73 extends Migration
{
    protected $modulename = 'update73';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_kunde'))
        {
            Schema::table('xsigns_fewo_kunde', function (Blueprint $table)
            {
                $table->integer('anzahlung_objpreis')->default(0)->change();
                $table->decimal('anzahlung_proz', 5, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_ang'))
        {
            Schema::table('xsigns_fewo_ang', function (Blueprint $table)
            {
                $table->decimal('ang_festpreis', 9, 2)->default(0)->change();
                $table->decimal('ang_prozent', 5, 2)->default(0)->change();
                $table->string('ang_alias', 250)->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_preise'))
        {
            Schema::table('xsigns_fewo_preise', function (Blueprint $table)
            {
                $table->decimal('preis', 9, 2)->default(0)->change();
                $table->decimal('weitere', 9, 2)->default(0)->change();
                $table->decimal('exportpreis', 9, 2)->default(0)->change();
                $table->decimal('anzahlung', 9, 2)->default(0)->change();
                $table->decimal('woche', 9, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_lelang'))
        {
            Schema::table('xsigns_fewo_lelang', function (Blueprint $table)
            {
                $table->string('titel2', 200)->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_vorgleist'))
        {
            Schema::table('xsigns_fewo_vorgleist', function (Blueprint $table)
            {
                $table->decimal('anzahl', 5, 2)->default(0)->change();
                $table->decimal('epreis', 9, 2)->default(0)->change();
                $table->decimal('summe', 9, 2)->default(0)->change();
                $table->decimal('mwst', 9, 2)->default(0)->change();
                $table->decimal('mwstbetrag', 9, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_objza'))
        {
            Schema::table('xsigns_fewo_objza', function (Blueprint $table)
            {
                $table->decimal('kaut', 5, 2)->default(0)->change();
                $table->decimal('anzproz', 9, 2)->default(0)->change();
                $table->decimal('anzmin', 9, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_objentf'))
        {
            Schema::table('xsigns_fewo_objentf', function (Blueprint $table)
            {
                $table->decimal('km', 7, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_objleist'))
        {
            Schema::table('xsigns_fewo_objleist', function (Blueprint $table)
            {
                $table->decimal('anz', 7, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_objstat'))
        {
            Schema::table('xsigns_fewo_objstat', function (Blueprint $table)
            {
                $table->integer('geklickt')->default(0)->change();
                $table->integer('angefragt')->default(0)->change();
                $table->integer('gebucht')->default(0)->change();
                $table->integer('wertung')->default(0)->change();
                $table->integer('gemerkt')->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_objbleist'))
        {
            Schema::table('xsigns_fewo_objbleist', function (Blueprint $table)
            {
                $table->decimal('anz', 7, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_aus'))
        {
            Schema::table('xsigns_fewo_aus', function (Blueprint $table)
            {
                $table->string('aus_sort', 20)->default('')->change();
                $table->string('aus_name', 250)->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_obj'))
        {
            Schema::table('xsigns_fewo_obj', function (Blueprint $table)
            {
                $table->string('obj_intnr', 100)->default('')->change();
                $table->decimal('obj_zimmer', 5, 2)->default(0)->change();
                $table->decimal('obj_groesse', 6, 2)->default(0)->change();
                $table->decimal('obj_etage', 5, 2)->default(0)->change();
                $table->decimal('obj_kaution', 9, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_le'))
        {
            Schema::table('xsigns_fewo_le', function (Blueprint $table)
            {
                $table->decimal('leist_mwst', 5, 2)->default(0)->change();
                $table->decimal('leist_preis', 9, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Schema::table('xsigns_fewo_buchung', function (Blueprint $table)
            {
                $table->decimal('objektpreis', 9, 2)->default(0)->change();
                $table->decimal('angebotpreis', 9, 2)->default(0)->change();
                $table->decimal('anzpreis', 9, 2)->default(0)->change();
                $table->decimal('leistpreis', 9, 2)->default(0)->change();
                $table->decimal('summe', 9, 2)->default(0)->change();
                $table->decimal('zuschlagpreis', 9, 2)->default(0)->change();
                $table->decimal('restzahlung', 9, 2)->default(0)->change();
                $table->decimal('gezahlt', 9, 2)->default(0)->change();
                $table->decimal('kaution', 9, 2)->default(0)->change();
                $table->decimal('gebuehr', 9, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_bewpunkte'))
        {
            Schema::table('xsigns_fewo_bewpunkte', function (Blueprint $table)
            {
                $table->decimal('punkte', 5, 2)->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_zu'))
        {
            Schema::table('xsigns_fewo_zu', function (Blueprint $table)
            {
                $table->decimal('zu_tagespreis', 7, 2)->default(0)->change();
                $table->decimal('zu_prozent', 7, 2)->default(0)->change();
            });
        }
    }

    public function down()
    {

    }
}