<?php namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update31 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_ang', function($table)
        {
            $table->integer('ang_tagevor')->unsigned()->index();
            $table->integer('ang_tagevart')->unsigned()->index();
        });
    }

    public function down()
    {


    }

}
