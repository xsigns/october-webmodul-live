<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update74 extends Migration
{
    protected $modulename = 'update74';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_objza'))
        {
            Schema::table('xsigns_fewo_objza', function (Blueprint $table)
            {
                $table->decimal('kaut', 9, 2)->default(0)->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_objza'))
        {
            Schema::table('xsigns_fewo_objza', function (Blueprint $table)
            {
                $table->decimal('kaut', 5, 2)->default(0)->change();
            });
        }
    }
}