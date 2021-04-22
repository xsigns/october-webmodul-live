<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate15 extends Migration
{
    public function up()
    {

        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->string('gebdatum',20)->nullable()->change();

        });
    }
    public function down()
    {

    }
}
