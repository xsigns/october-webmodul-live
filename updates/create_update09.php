<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate9 extends Migration
{
    public function up()
    {

        Schema::table('xsigns_fewo_ha', function($table)
        {
            $table->engine = 'InnoDB';
            $table->index(['haus_land']);
        });
    }
    public function down()
    {

    }
}