<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update83 extends Migration
{
    protected string $modulename = 'update83';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_le'))
        {
            Schema::table('xsigns_fewo_le', function (Blueprint $table)
            {
               $table->string('leist_fremd_id', 150)->default('');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_le'))
        {
            Schema::table('xsigns_fewo_le', function (Blueprint $table)
            {
                $table->dropColumn('leist_fremd_id');
            });
        }
    }
}