<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DatabaseIndexHelper;

class Update66 extends Migration
{
    protected $modulename = 'update66';

    public function up()
    {
        Schema::table('xsigns_fewo_preiselang', function ($table)
        {
            $table->integer('preislng_preisid')->default(0)->change();

            if (!DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_preiselang', 'preislng_preisid_preislng_lang'))
                $table->index(['preislng_preisid', 'preislng_lang'], 'preislng_preisid_preislng_lang');
        });

        Schema::table('xsigns_fewo_ang', function ($table)
        {
            if (!DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_ang', 'ang_id_ang_aktiv_ang_bis'))
                $table->index(['ang_id', 'ang_aktiv', 'ang_bis'], 'ang_id_ang_aktiv_ang_bis');
        });

        Schema::table('xsigns_fewo_aus', function ($table)
        {
            if (!DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_aus', 'ausid'))
                $table->unique('ausid');
        });

        Schema::table('xsigns_fewo_zu', function ($table)
        {
            if (!DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_zu', 'zu_zeitraumaktiv_zu_bis_zu_tage_zu_kurzbucher_zu_objartid'))
                $table->index(['zu_zeitraumaktiv', 'zu_bis', 'zu_tage', 'zu_kurzbucher', 'zu_objartid'], 'zu_zeitraumaktiv_zu_bis_zu_tage_zu_kurzbucher_zu_objartid');
        });

        Schema::table('xsigns_fewo_bewpunkte', function ($table)
        {
            $table->integer('bewertung_id')->default(0)->change();

            if (!DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_bewpunkte', 'bewertung_id_option_id'))
                $table->index(['bewertung_id', 'option_id'], 'bewertung_id_option_id');
        });

        if (Schema::hasColumn('xsigns_fewo_buchung', 'completed'))
        {
            Schema::table('xsigns_fewo_buchung', function ($table)
            {
                $table->dropColumn('completed');
            });
        }
    }

    public function down()
    {

    }
}