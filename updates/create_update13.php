<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate13 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_abrechnung', function($table)
        {
            $table->dropColumn('abr_wartung1');
            $table->dropColumn('abr_wartung2');
            $table->dropColumn('abr_wartung3');
            $table->dropColumn('abr_wartung4');
            $table->text('abr_wartung'); // Hier kommt Json rein
            $table->date('abr_datefrom');
            $table->date('abr_dateto');
        });



    }

    public function down()
    {

    }

}