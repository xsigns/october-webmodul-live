<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update48 extends Migration
{
    protected $modulename = 'update48';

    public function up()
    {
        Schema::table('xsigns_fewo_imagelang', function ($table) {
            $table->renameColumn('objid', 'imglang_objid');
            $table->string('imglang_bildnr', 191);
            $table->renameColumn('lang', 'imglang_lang');
            $table->renameColumn('titel', 'imglang_titel');
            $table->renameColumn('html', 'imglang_html');
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_imagelang', function ($table) {
            $table->renameColumn('imglang_objid', 'objid');
            $table->dropColumn('imglang_bildnr');
            $table->renameColumn('imglang_lang', 'lang');
            $table->renameColumn('imglang_titel', 'titel');
            $table->renameColumn('imglang_html', 'html');
        });
    }
}
