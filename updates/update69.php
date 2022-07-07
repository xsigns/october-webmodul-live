<?php

namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update69 extends Migration
{
    protected $modulename = 'update69';

    public function up()
    {
        Schema::table('xsigns_fewo_obj', function ($table)
        {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes($table->getTable());

            if (!array_key_exists('aktiv_preisanzahl', $indexes))
                $table->index(['obj_aktiv', 'obj_preisanzahl'], 'aktiv_preisanzahl');
        });
    }

    public function down()
    {

    }
}