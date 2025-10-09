<?php

namespace updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DatabaseIndexHelper;


class Update82 extends Migration
{
    protected string $modulename = 'update82';

    public function up()
    {
        if (Schema::hasTable('system_files'))
        {
            Schema::table('system_files', function (Blueprint $table)
            {
                if (!DatabaseIndexHelper::checkIfIndexExists('system_files', 'system_files_disk_name_index'))
                    $table->index('disk_name', 'system_files_disk_name_index');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('system_files'))
        {
            Schema::table('system_files', function (Blueprint $table)
            {
                if (DatabaseIndexHelper::checkIfIndexExists('system_files', 'system_files_disk_name_index'))
                    $table->dropIndex('system_files_disk_name_index');
            });
        }
    }
}