<?php namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update29 extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('xsigns_fewo_buchung', 'artikel')) {
            Schema::table('xsigns_fewo_buchung', function($table)
            {
                $table->dropColumn('artikel');
            });
        }
    }

    public function down()
    {


    }

}
