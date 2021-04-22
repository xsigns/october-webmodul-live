<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate10 extends Migration
{
    public function up()
    {

        Schema::table('xsigns_fewo_preise', function($table)
        {
            $table->string('anreise',20)->nullable()->change();

        });
    }
    public function down()
    {

    }
}