<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update42 extends Migration
{
    protected $modulename = 'update42';

    public function up()
    {
        Schema::table('xsigns_fewo_auskat', function ($table) {
            $table->index(['auskat_sort'], 'sort');
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_auskat', function ($table) {
            $table->dropIndex('sort');
        });
    }
}
