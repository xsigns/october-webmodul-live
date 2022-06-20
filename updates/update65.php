<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update65 extends Migration
{
    protected $modulename = 'update65';

    public function up()
    {
        Schema::table('xsigns_fewo_bew', function ($table)
        {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes($table->getTable());

            if (array_key_exists('objid_aktiv', $indexes))
                $table->dropIndex('objid_aktiv');
        });

        Schema::table('xsigns_fewo_obj', function ($table)
        {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes($table->getTable());

            if (!array_key_exists('aktiv_preisbis_id', $indexes))
                $table->index(['obj_aktiv', 'obj_preisbis', 'id'], 'aktiv_preisbis_id');
        });
    }

    public function down()
    {

    }
}