<?php

namespace updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update87 extends Migration
{
    protected string $modulename = 'update87';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_zahlungen'))
        {
            Schema::table('xsigns_fewo_zahlungen', function (Blueprint $table)
            {
                if (!Schema::hasColumn('xsigns_fewo_zahlungen', 'za_restz_payid'))
                    $table->string('za_restz_payid', 100)->default('');

                if (!Schema::hasColumn('xsigns_fewo_zahlungen', 'za_restz_receiptnumber'))
                    $table->string('za_restz_receiptnumber', 100)->default('');

                if (!Schema::hasColumn('xsigns_fewo_zahlungen', 'za_sync'))
                    $table->integer('za_sync')->default(0);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_zahlungen'))
        {
            Schema::table('xsigns_fewo_zahlungen', function (Blueprint $table)
            {
                if (Schema::hasColumn('xsigns_fewo_zahlungen', 'za_restz_payid'))
                    $table->dropColumn('za_restz_payid');

                if (Schema::hasColumn('xsigns_fewo_zahlungen', 'za_restz_receiptnumber'))
                    $table->dropColumn('za_restz_receiptnumber');

                if (Schema::hasColumn('xsigns_fewo_zahlungen', 'za_sync'))
                    $table->dropColumn('za_sync');
            });
        }
    }
}