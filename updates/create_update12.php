<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate12 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->string('pay_status',11)->nullable();
        });

    }

    public function down()
    {
        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->dropColumn('pay_status');
        });

    }

}