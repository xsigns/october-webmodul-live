<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update53 extends Migration
{
    protected $modulename = 'update53';

    public function up()
    {
        Schema::table('xsigns_fewo_vorggesendet', function ($table) {
            $table->string('vorgges_grundbew', 250);
            $table->string('vorgges_grundanschr', 250);
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_vorggesendet', function ($table) {
            $table->dropColumn('vorgges_grundbew');
            $table->dropColumn('vorgges_grundanschr');
        });
    }
}