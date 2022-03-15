<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update61 extends Migration
{
    protected $modulename = 'update61';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Schema::table('xsigns_fewo_buchung', function ($table)
            {
                $table->string('orderHash', 250)->nullable()->change();
                $table->string('typeof', 250)->nullable()->change();
                $table->string('rueckruf', 250)->nullable()->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Schema::table('xsigns_fewo_buchung', function ($table)
            {
                $table->string('orderHash', 255)->nullable()->change();
                $table->string('typeof', 255)->default('')->change();
                $table->string('rueckruf', 255)->nullable()->change();
            });
        }
    }
}