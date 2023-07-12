<?php

namespace Xsigns\Fewo\Updates;

use mysql_xdevapi\Exception;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\Logger;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class Update63 extends Migration
{
    protected $modulename = 'update63';

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_ang'))
        {
            Schema::table('xsigns_fewo_ang', function ($table)
            {
                $table->integer('ang_tagezahlen')->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_auslang'))
        {
            Schema::table('xsigns_fewo_auslang', function ($table)
            {
                $table->string('auslang_name', 200)->default('')->change();
                $table->string('auslang_lang', 3)->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_imagelang'))
        {
            Schema::table('xsigns_fewo_imagelang', function ($table)
            {
                $table->string('imglang_bildnr', 191)->default('0')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_lelang'))
        {
            Schema::table('xsigns_fewo_lelang', function ($table)
            {
                $table->string('titel', 200)->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_obj'))
        {
            Schema::table('xsigns_fewo_obj', function ($table)
            {
                $table->string('obj_buart', 191)->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_vorg'))
        {
            if (!Type::hasType('char')) {
                Type::addType('char', StringType::class);
            }

            Schema::table('xsigns_fewo_vorg', function ($table)
            {
                $table->char('vorg_buid', 20)->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_zu'))
        {
            Schema::table('xsigns_fewo_zu', function ($table)
            {
                $table->integer('zu_personen')->unsigned()->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Schema::table('xsigns_fewo_buchung', function ($table)
            {
                $table->string('firma', 120)->nullable()->change();
                $table->string('vorname', 120)->nullable()->change();
                $table->string('zuname', 120)->nullable()->change();
            });
        }
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_ang'))
        {
            Schema::table('xsigns_fewo_ang', function ($table)
            {
                $table->integer('ang_tagezahlen')->default(0)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_auslang'))
        {
            Schema::table('xsigns_fewo_auslang', function ($table)
            {
                $table->string('auslang_name', 200)->default('')->change();
                $table->string('auslang_lang', 3)->default('')->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_imagelang'))
        {
            Schema::table('xsigns_fewo_imagelang', function ($table)
            {
                $table->string('imglang_bildnr', 191)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_lelang'))
        {
            Schema::table('xsigns_fewo_lelang', function ($table)
            {
                $table->string('titel', 200)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_obj'))
        {
            Schema::table('xsigns_fewo_obj', function ($table)
            {
                $table->string('obj_buart', 191)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_vorg'))
        {
            if (!Type::hasType('char')) {
                Type::addType('char', StringType::class);
            }

            Schema::table('xsigns_fewo_vorg', function ($table)
            {
                $table->char('vorg_buid', 20)->change();
            });
        }

        if (Schema::hasTable('xsigns_fewo_zu'))
        {
            Schema::table('xsigns_fewo_zu', function ($table)
            {
                $table->integer('zu_personen')->unsigned()->change();
            });
        }
    }
}