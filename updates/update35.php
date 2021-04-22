<?php

namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Fewo;

class Update35 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_obj', function($table) {
            $table->string('obj_buart');
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_obj', function($table) {
            $table->dropColumn('obj_buart');
        });
    }
}