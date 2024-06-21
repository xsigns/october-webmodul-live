<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update84 extends Migration
{
    protected string $modulename = 'update84';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_imagelang'))
        {
            Schema::table('xsigns_fewo_imagelang', function (Blueprint $table)
            {
                $table->text('imglang_html')->nullable()->default(null)->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_imagelang'))
        {
            Schema::table('xsigns_fewo_imagelang', function (Blueprint $table)
            {
                $table->string('imglang_html', 191)->default('')->change();
            });
        }
    }
}