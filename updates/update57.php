<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update57 extends Migration
{
    protected $modulename = 'update57';

    public function up()
    {
        Schema::table('xsigns_fewo_abrechnung', function ($table) {
            $table->string('abr_rechnr', 50)->default('0');
            $table->decimal('abr_betrag', 5, 2)->default(0.00);
            $table->decimal('abr_provbetrag', 5, 2)->default(0.00);
        });

        \DB::delete("delete from xsigns_fewo_abrechnung");
    }

    public function down()
    {
        Schema::table('xsigns_fewo_abrechnung', function ($table) {
            $table->dropColumn('abr_rechnr');
            $table->dropColumn('abr_betrag');
            $table->dropColumn('abr_provbetrag');
        });
    }
}
