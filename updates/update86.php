<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update86 extends Migration
{
    protected string $modulename = 'update86';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_obj'))
        {
            Schema::table('xsigns_fewo_obj', function (Blueprint $table)
            {
                if (!Schema::hasColumn('xsigns_fewo_obj', 'obj_regionaleregistrierungsnr'))
                    $table->string('obj_regionaleregistrierungsnr', 100)->default('');

                if (!Schema::hasColumn('xsigns_fewo_obj', 'obj_nationaleregistrierungsnr'))
                    $table->string('obj_nationaleregistrierungsnr', 100)->default('');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_obj'))
        {
            Schema::table('xsigns_fewo_obj', function (Blueprint $table)
            {
                if (Schema::hasColumn('xsigns_fewo_obj', 'obj_regionaleregistrierungsnr'))
                    $table->dropColumn('obj_regionaleregistrierungsnr');

                if (!Schema::hasColumn('xsigns_fewo_obj', 'obj_nationaleregistrierungsnr'))
                    $table->dropColumn('obj_nationaleregistrierungsnr');
            });
        }
    }
}