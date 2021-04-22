<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate7 extends Migration
{
    public function up()
    {

        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->string('receiptnumber',200);
        });
    }
    public function down()
    {

    }
}