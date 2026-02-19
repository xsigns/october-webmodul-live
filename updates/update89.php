<?php

namespace updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update89 extends Migration
{
    protected string $modulename = 'update89';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_vorggesendet'))
        {
            Schema::table('xsigns_fewo_vorggesendet', function (Blueprint $table)
            {
                if (!Schema::hasColumn('xsigns_fewo_vorggesendet', 'vorabreise'))
                    $table->integer('vorabreise')->default(0);

                if (!Schema::hasColumn('xsigns_fewo_vorggesendet', 'vorgges_grundvorabreise'))
                    $table->string('vorgges_grundvorabreise', 250)->default('');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_vorggesendet'))
        {
            Schema::table('xsigns_fewo_vorggesendet', function (Blueprint $table)
            {
                if (Schema::hasColumn('xsigns_fewo_vorggesendet', 'vorabreise'))
                    $table->dropColumn('vorabreise');

                if (Schema::hasColumn('xsigns_fewo_vorggesendet', 'vorgges_grundvorabreise'))
                    $table->dropColumn('vorgges_grundvorabreise');
            });
        }
    }
}