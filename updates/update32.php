<?php


namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update32 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_obj', function($table) {
            $table->string('obj_alias', 150)->change();
            $table->index(['obj_personen', 'obj_aktiv', 'obj_sort']);
        });

        Schema::table('xsigns_fewo_orte', function($table) {
            $table->string('ort_name', 150)->change();
        });

        Schema::table('xsigns_fewo_ang', function ($table) {
            $table->index(['ang_aktiv', 'ang_bis']);
        });

        Schema::table('xsigns_fewo_halang', function ($table) {
            $table->index('name');
            $table->string('name', 250)->change();
        });
    }

    public function down()
    {

    }
}