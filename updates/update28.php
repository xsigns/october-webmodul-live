<?php namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update28 extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('xsigns_fewo_buchung', 'created')) {
            Schema::table('xsigns_fewo_buchung', function($table)
            {
                $table->timestamp('created')->useCurrent();
            });
        }
    }

    public function down()
    {


    }

}
