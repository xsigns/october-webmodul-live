<?php namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update30 extends Migration
{
    public function up()
    {
            Schema::table('xsigns_fewo_obj', function($table)
            {
                $table->integer('obj_minalter')->unsigned()->index();
            });
    }

    public function down()
    {


    }

}
