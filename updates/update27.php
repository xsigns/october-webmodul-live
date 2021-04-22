<?php namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update27 extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('xsigns_fewo_preise', 'abreise')) {
            Schema::table('xsigns_fewo_preise', function($table)
            {
                $table->string('abreise',20)->nullable()->default('');
            });
        }
    }

    public function down()
    {


    }

}
