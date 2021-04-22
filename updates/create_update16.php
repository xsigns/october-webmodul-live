<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate16 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_le', function($table)
        {
            $table->integer('leist_tage')->nullable()->unsigned()->default(0);
            $table->integer('leist_typ')->nullable()->unsigned()->default(0);
        });
    }

    public function down()
    {


    }

}