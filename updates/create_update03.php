<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate3 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_kunde', function($table)
        {
            $table->integer('feondi')->default(0)->unsigned();
        });
    }

    public function down()
    {

    }
}