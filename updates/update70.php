<?php

namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update70 extends Migration
{
    protected $modulename = 'update70';

    public function up()
    {
        if (!Schema::hasColumns('xsigns_fewo_zahlungen', ['za_gast_name', 'za_status']))
        {
            Schema::table('xsigns_fewo_zahlungen', function ($table)
            {
                $table->string('za_gast_name', 120)->default('');
                $table->string('za_status', 200)->default('');
            });
        }

        Db::update("update xsigns_fewo_zahlungen inner join xsigns_fewo_buchung on xsigns_fewo_buchung.id = za_buid set za_gast_name = zuname");
    }

    public function down()
    {

    }
}