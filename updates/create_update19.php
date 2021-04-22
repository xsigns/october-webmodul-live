<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate19 extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('xsigns_fewo_ang', 'ang_zuschlag')) {
            Schema::table('xsigns_fewo_ang', function($table)
            {
                $table->integer('ang_zuschlag')->nullable()->unsigned()->default(1);
            });
        }
    }

    public function down()
    {


    }

}