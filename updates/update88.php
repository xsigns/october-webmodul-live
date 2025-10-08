<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update88 extends Migration
{
    protected string $modulename = 'update87';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Schema::table('xsigns_fewo_buchung', function (Blueprint $table)
            {
                if (!Schema::hasColumn('xsigns_fewo_buchung', 'ist_geschaeftsreise'))
                    $table->integer('ist_geschaeftsreise')->default(0);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_buchung'))
        {
            Schema::table('xsigns_fewo_buchung', function (Blueprint $table)
            {
                if (Schema::hasColumn('xsigns_fewo_buchung', 'ist_geschaeftsreise'))
                    $table->dropColumn('ist_geschaeftsreise');
            });
        }
    }
}