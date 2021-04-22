<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update41 extends Migration
{
    protected $modulename = 'update41';

    public function up()
    {
        Schema::table('xsigns_fewo_auslang', function ($table) {
            $table->renameColumn('ausid', 'auslang_ausid');
            $table->renameColumn('name', 'auslang_name');
            $table->renameColumn('lang', 'auslang_lang');
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_auslang', function ($table) {
            $table->renameColumn('auslang_ausid', 'ausid');
            $table->renameColumn('auslang_name', 'name');
            $table->renameColumn('auslang_lang', 'lang');
        });
    }
}
