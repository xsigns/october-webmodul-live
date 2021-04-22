<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update44 extends Migration
{
    protected $modulename = 'update44';

    public function up()
    {
        Schema::table('xsigns_fewo_reglang', function ($table) {
            $table->renameColumn('regionid', 'reglang_regionid');
            $table->renameColumn('lang', 'reglang_lang');
            $table->renameColumn('name', 'reglang_name');
            $table->renameColumn('beschreibung', 'reglang_beschreibung');
            $table->renameColumn('kurz', 'reglang_kurz');
            $table->renameColumn('seo', 'reglang_seo');
        });
        Schema::table('xsigns_fewo_artlang', function ($table) {
            $table->renameColumn('artid', 'artlang_artid');
            $table->renameColumn('lang', 'artlang_lang');
            $table->renameColumn('name', 'artlang_name');
        });
        Schema::table('xsigns_fewo_typlang', function ($table) {
            $table->renameColumn('typid', 'typlang_typid');
            $table->renameColumn('lang', 'typlang_lang');
            $table->renameColumn('name', 'typlang_name');
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_reglang', function ($table) {
            $table->renameColumn('reglang_ausid', 'regionid');
            $table->renameColumn('reglang_lang', 'lang');
            $table->renameColumn('reglang_name', 'name');
            $table->renameColumn('reglang_beschreibung', 'beschreibung');
            $table->renameColumn('reglang_kurz', 'kurz');
            $table->renameColumn('reglang_seo', 'seo');
        });
        Schema::table('xsigns_fewo_artlang', function ($table) {
            $table->renameColumn('artlang_artid', 'artid');
            $table->renameColumn('artlang_lang', 'lang');
            $table->renameColumn('artlang_name', 'name');
        });
        Schema::table('xsigns_fewo_typlang', function ($table) {
            $table->renameColumn('typlang_typid', 'typid');
            $table->renameColumn('typlang_lang', 'lang');
            $table->renameColumn('typlang_name', 'name');
        });
    }
}
