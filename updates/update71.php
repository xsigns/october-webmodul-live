<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update71 extends Migration
{
    protected $modulename = 'update71';

    public function up()
    {
        if (!Schema::hasColumn('xsigns_fewo_obj', 'obj_tarifzone'))
        {
            Schema::table('xsigns_fewo_obj', function ($table)
            {
                $table->string('obj_tarifzone', 20)->default('');
            });
        }

        if (!Schema::hasTable('xsigns_fewo_tarifzonen'))
        {
            Schema::create('xsigns_fewo_tarifzonen', function ($table) {
                $table->increments('id');
                $table->string('tz_id', 20)->default('');
                $table->string('tz_name', 150)->default('');
                $table->date('tz_ab')->default('1001-01-01');
                $table->string('tz_formel', 200)->default('');
                $table->index('tz_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('xsigns_fewo_obj', 'obj_tarifzone'))
        {
            Schema::table('xsigns_fewo_obj', function ($table)
            {
                $table->dropColumn('obj_tarifzone');
            });
        }

        Schema::dropIfExists('xsigns_fewo_tarifzonen');
    }
}