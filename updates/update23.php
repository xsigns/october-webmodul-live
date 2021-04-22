<?php namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update23 extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('xsigns_fewo_obj', 'aus_name')) {
            Schema::table('xsigns_fewo_obj', function ($table) {
                $table->dropColumn('aus_name');
            });
        }
        if (!Schema::hasColumn('xsigns_fewo_obj', 'obj_canonical')) {
            Schema::table('xsigns_fewo_obj', function($table)
            {
                $table->string('obj_canonical',400)->nullable()->default('');
            });
        }
        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->string('iban',60)->nullable()->default('')->change();
        });
        Schema::table('xsigns_fewo_kunde', function($table)
        {
            $table->string('bankiban',60)->nullable()->default('')->change();
        });
    }

    public function down()
    {


    }

}

