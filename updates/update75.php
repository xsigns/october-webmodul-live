<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update75 extends Migration
{
    protected $modulename = 'update75';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_raum'))
        {
            Schema::table('xsigns_fewo_raum', function (Blueprint $table)
            {
                $table->string('objid',20)->default('')->change();

                if (!Schema::hasColumns('xsigns_fewo_raum', ['shared', 'bath_access']))
                {
                    $table->integer('shared')->default(0);
                    $table->integer('bath_access')->default(0);
                }
            });
        }

        if (Schema::hasTable('xsigns_fewo_ralang'))
        {
            Schema::table('xsigns_fewo_ralang', function (Blueprint $table)
            {
                $table->string('objid',20)->default('')->change();
                $table->string('art',2)->default('');
            });
        }

        if (Schema::hasTable('xsigns_fewo_obj'))
        {
            if (Schema::hasColumn('xsigns_fewo_obj', 'obj_belplan'))
            {
                Schema::table('xsigns_fewo_obj', function (Blueprint $table)
                {
                    $table->dropColumn('obj_belplan');
                });
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_raum'))
        {
            Schema::table('xsigns_fewo_raum', function (Blueprint $table)
            {
                $table->integer('objid')->default(0)->unsigned()->change();

                if (Schema::hasColumns('xsigns_fewo_raum', ['shared', 'bath_access']))
                {
                    $table->dropColumn('shared');
                    $table->dropColumn('bath_access');
                }
            });
        }

        if (Schema::hasTable('xsigns_fewo_ralang'))
        {
            Schema::table('xsigns_fewo_ralang', function (Blueprint $table)
            {
                $table->dropColumn('art');
            });
        }
    }
}