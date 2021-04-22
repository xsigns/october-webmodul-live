<?php


namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update34 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_obj', function($table) {
            $table->decimal('obj_groesse', 6, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_obj', function($table) {
            $table->decimal('obj_groesse', 5, 2)->change();
        });
    }
}