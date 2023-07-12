<?php

namespace updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update78 extends Migration
{
    protected string $modulename = 'update78';

    public function up()
    {
        if (Schema::hasTable('xsigns_fewo_abrechnung') && !Schema::hasColumn('xsigns_fewo_abrechnung', 'abr_belege'))
        {
            Schema::table('xsigns_fewo_abrechnung', function (Blueprint $table)
            {
                $table->text('abr_belege')->nullable();
            });
        }

        Database::select(null, $this->modulename, "update xsigns_fewo_abrechnung set abr_belege = '[]'");

        if (Schema::hasTable('xsigns_fewo_preise') && !Schema::hasColumn('xsigns_fewo_preise', 'pausentage'))
        {
            Schema::table('xsigns_fewo_preise', function (Blueprint $table)
            {
                $table->integer('pausentage')->default(0);
            });
        }

        Database::select(null, $this->modulename, "update xsigns_fewo_preise set abreise = '9'");
    }

    public function down()
    {
        if (Schema::hasTable('xsigns_fewo_abrechnung') && Schema::hasColumn('xsigns_fewo_abrechnung', 'abr_belege'))
        {
            Schema::table('xsigns_fewo_abrechnung', function (Blueprint $table)
            {
                $table->dropColumn('abr_belege');
            });
        }

        if (Schema::hasTable('xsigns_fewo_preise') && Schema::hasColumn('xsigns_fewo_preise', 'pausentage'))
        {
            Schema::table('xsigns_fewo_preise', function (Blueprint $table)
            {
                $table->dropColumn('pausentage');
            });
        }
    }
}