<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate4 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_obj', function($table)
        {
            $table->integer('obj_sort')->default(0)->unsigned()->change();
        });
    }

    public function down()
    {

    }
}