<?php

namespace Xsigns\Fewo\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class Update90 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_buchung', function ($table) {
            $table->decimal('pay_expected_amount', 14, 2)->nullable();
            $table->boolean('pay_is_deposit')->nullable();
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_buchung', function ($table) {
            $table->dropColumn(['pay_expected_amount', 'pay_is_deposit']);
        });
    }
}
