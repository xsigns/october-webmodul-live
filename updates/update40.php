<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update40 extends Migration
{
    protected $modulename = 'update40';

    public function up()
    {
        Schema::table('xsigns_fewo_auskatlang', function ($table) {
            $table->renameColumn('katid', 'auskat_katid');
            $table->renameColumn('name', 'auskat_name');
            $table->renameColumn('lang', 'auskat_lang');
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_auskatlang', function ($table) {
            $table->renameColumn('auskat_katid', 'katid');
            $table->renameColumn('auskat_name', 'name');
            $table->renameColumn('auskat_lang', 'lang');
        });
    }
}
