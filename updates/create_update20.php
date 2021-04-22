<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate20 extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('xsigns_fewo_obj', 'obj_canonical')) {
            Schema::table('xsigns_fewo_obj', function($table)
            {
                $table->string('obj_canonical',200)->nullable()->default('');
            });
        }
    }

    public function down()
    {


    }

}
