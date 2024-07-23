<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update85 extends Migration
{
    protected string $modulename = 'update85';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_objlang'))
        {
            Schema::table('xsigns_fewo_objlang', function (Blueprint $table)
            {
                $table->text('titeltag')->nullable()->default(null);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_objlang'))
        {
            Schema::table('xsigns_fewo_objlang', function (Blueprint $table)
            {
                $table->dropColumn('titeltag');
            });
        }
    }
}