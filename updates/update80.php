<?php

namespace Xsigns\Fewo\Updates;

use DateTime;
use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DoctrineSchemaManager;
use Xsigns\Fewo\Classes\FewoDatum;
use Xsigns\Fewo\Classes\Objekt;

class Update80 extends Migration
{
    protected string $modulename = 'update80';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_objsuchindex'))
        {
            Schema::table('xsigns_fewo_objsuchindex', function (Blueprint $table)
            {
                $sm = DoctrineSchemaManager::getSchemaManager();
                $indexes = $sm->listTableIndexes($table->getTable());

                if (!array_key_exists('leisteab', $indexes))
                    $table->index('objsuchindex_leisteab', 'leisteab');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_objsuchindex'))
        {
            Schema::table('xsigns_fewo_objsuchindex', function (Blueprint $table)
            {
                $sm = DoctrineSchemaManager::getSchemaManager();
                $indexes = $sm->listTableIndexes($table->getTable());

                if (array_key_exists('leisteab', $indexes))
                    $table->dropIndex('leisteab');
            });
        }
    }
}