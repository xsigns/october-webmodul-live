<?php

namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DoctrineSchemaManager;

class Update68 extends Migration
{
    protected $modulename = 'update68';

    public function up()
    {
        Schema::table('xsigns_fewo_bewopt', function ($table)
        {
            $table->integer('id')->default(0)->change();
        });

        Schema::table('xsigns_fewo_reglang', function ($table)
        {
            $table->integer('reglang_regionid')->default(0)->change();

            $sm = DoctrineSchemaManager::getSchemaManager();
            $indexes = $sm->listTableIndexes($table->getTable());

            if (!array_key_exists('regionid_lang_name', $indexes))
                $table->index(['reglang_regionid', 'reglang_lang', 'reglang_name'], 'regionid_lang_name');
        });

        Schema::table('xsigns_fewo_vorg', function ($table)
        {
            $sm = DoctrineSchemaManager::getSchemaManager();
            $indexes = $sm->listTableIndexes($table->getTable());

            if (!array_key_exists('objid_anreise_abreise', $indexes))
                $table->index(['vorg_objid', 'vorg_anreise', 'vorg_abreise'], 'objid_anreise_abreise');
        });

        Schema::table('xsigns_fewo_preise', function ($table)
        {
            $sm = DoctrineSchemaManager::getSchemaManager();
            $indexes = $sm->listTableIndexes($table->getTable());

            if (!array_key_exists('objid_von_bis_mintage_lueckenbok_anreise_abreise', $indexes))
                $table->index(['objid', 'von', 'bis', 'mintage', 'lueckenbok', 'anreise', 'abreise'], 'objid_von_bis_mintage_lueckenbok_anreise_abreise');
        });

        Schema::table('xsigns_fewo_zahlungen', function ($table)
        {
            $table->integer('za_anz_gezahlt')->default(0)->change();
            $table->integer('za_restz_gezahlt')->default(0)->change();
        });

        //Db::update("update xsigns_fewo_zahlungen set za_restz_am = now() + interval 1 day where za_restz_am < now() and (za_restz_gezahlt = 1 or za_restz_gezahlt = 0) and (za_restz_gezahlt_am = '1001-01-01' or za_restz_gezahlt_am = '0000-00-00')");
        Db::update("update xsigns_fewo_zahlungen set za_restz_am = now() + interval 1 day where za_restz_am < now() and (za_restz_gezahlt = 1 or za_restz_gezahlt = 0) and (za_restz_gezahlt_am = '1001-01-01')");
    }

    public function down()
    {

    }
}
