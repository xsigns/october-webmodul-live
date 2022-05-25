<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update64 extends Migration
{
    protected $modulename = 'update64';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_vorgmit'))
        {
            Schema::table('xsigns_fewo_vorgmit', function ($table)
            {
                $table->string('vorname', 120)->nullable()->default('')->change();
                $table->string('name', 120)->nullable()->default('')->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_vorgmit'))
        {
            Schema::table('xsigns_fewo_vorgmit', function ($table)
            {
                $table->string('vorname', 30)->nullable()->default('')->change();
                $table->string('name', 30)->nullable()->default('')->change();
            });
        }
    }
}