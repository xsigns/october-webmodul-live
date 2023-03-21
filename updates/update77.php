<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update77 extends Migration
{
    protected string $modulename = 'update77';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_buchung') && !Schema::hasColumn('xsigns_fewo_buchung', 'kurtaxepreis'))
        {
            Schema::table('xsigns_fewo_buchung', function (Blueprint $table)
            {
                $table->decimal('kurtaxepreis', 9, 2)->default(0);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_buchung') && Schema::hasColumn('xsigns_fewo_buchung', 'kurtaxepreis'))
        {
            Schema::table('xsigns_fewo_buchung', function (Blueprint $table)
            {
                $table->dropColumn('kurtaxepreis');
            });
        }
    }
}