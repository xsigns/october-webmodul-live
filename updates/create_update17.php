<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate17 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_gast', function($table)
        {
            $table->integer('gast_werbemail')->nullable()->unsigned()->default(0);
        });
        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->integer('werbemail')->nullable()->unsigned()->default(0);
        });
        Schema::table('xsigns_fewo_preise', function($table)
        {
            $table->integer('lueckemintage')->nullable()->unsigned()->default(1);
        });
    }

    public function down()
    {


    }

}