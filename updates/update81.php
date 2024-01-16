<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update81 extends Migration
{
    protected string $modulename = 'update81';

    public function up()
    {
        if (!Schema::hasTable('xsigns_fewo_rabatte'))
        {
            Schema::create('xsigns_fewo_rabatte', function (Blueprint $table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('rabatt_id', 20)->default('0');
                $table->string('rabatt_name', 150)->default('');
                $table->integer('rabatt_buzeitraum_aktiv')->default(0);
                $table->date('rabatt_buzeit_von')->default('1001-01-01');
                $table->date('rabatt_buzeit_bis')->default('1001-01-01');
                $table->integer('rabatt_reisezeitraum_aktiv')->default(0);
                $table->date('rabatt_reisezeitraum_von')->default('1001-01-01');
                $table->date('rabatt_reisezeitraum_bis')->default('1001-01-01');
                $table->integer('rabatt_buchung_min_naechte_vor_anreise')->default(0);
                $table->integer('rabatt_min_laenge_anzahl_naechte')->default(0);
                $table->integer('rabatt_automatisch_anwenden')->default(0);
                $table->integer('rabatt_auf_gesamtsumme_anwenden')->default(0);
                $table->decimal('rabatt_prozent', 9)->default(0.00);
                $table->decimal('rabatt_betrag', 9)->default(0.00);

                $table->index(['rabatt_automatisch_anwenden'], 'rabatt_automatisch_anwenden');
                $table->index(['rabatt_buzeit_von', 'rabatt_buzeit_bis', 'rabatt_reisezeitraum_von', 'rabatt_reisezeitraum_bis'], 'buzeit_von_buzeit_bis_reisezeitraum_von_reisezeitraum_bis');
                $table->index(['rabatt_buchung_min_naechte_vor_anreise', 'rabatt_min_laenge_anzahl_naechte'], 'buchung_min_naechte_vor_anreise_min_laenge_anzahl_naechte');
                $table->index(['rabatt_prozent', 'rabatt_betrag'], 'prozent_betrag');
            });
        }

        if (!Schema::hasTable('xsigns_fewo_objrabatte'))
        {
            Schema::create('xsigns_fewo_objrabatte', function (Blueprint $table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('objrabatte_objid', 20)->default('0');
                $table->string('objrabatte_rabattid', 20)->default('0');

                $table->index(['objrabatte_rabattid'], 'rabatt_id');
                $table->index(['objrabatte_rabattid', 'objrabatte_objid'], 'rabattid_objid');
            });
        }

        if (!Schema::hasColumn('xsigns_fewo_buchung', 'gastmail_gesendet'))
        {
            Schema::table('xsigns_fewo_buchung', function (Blueprint $table) {
                $table->integer('gastmail_gesendet')->default(0);
            });

            Database::execute(null, $this->modulename, "update xsigns_fewo_buchung set gastmail_gesendet = 1");
        }

        if (!Schema::hasColumns('xsigns_fewo_ang', ['ang_buzeitraum_aktiv', 'ang_buzeit_von', 'ang_buzeit_bis']))
        {
            Schema::table('xsigns_fewo_ang', function (Blueprint $table) {
                $table->integer('ang_buzeitraum_aktiv')->default(0);
                $table->date('ang_buzeit_von')->default('1001-01-01');
                $table->date('ang_buzeit_bis')->default('1001-01-01');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_rabatte');
        Schema::dropIfExists('xsigns_fewo_objrabatte');

        if (Schema::hasColumn('xsigns_fewo_buchung', 'gastmail_gesendet'))
            Schema::dropColumns('xsigns_fewo_buchung', 'gastmail_gesendet');

        if (Schema::hasColumns('xsigns_fewo_ang', ['ang_buzeitraum_aktiv', 'ang_buzeit_von', 'ang_buzeit_bis']))
            Schema::dropColumns('xsigns_fewo_ang', ['ang_buzeitraum_aktiv', 'ang_buzeit_von', 'ang_buzeit_bis']);
    }
}