<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DatabaseIndexHelper;

class Update67 extends Migration
{
    protected $modulename = 'update67';

    public function up()
    {
        if (Schema::hasColumn('xsigns_fewo_buchung', 'register'))
        {
            Schema::table('xsigns_fewo_buchung', function ($table)
            {
                $table->string('register', 1)->nullable()->change();
            });
        }

        Schema::table('xsigns_fewo_buchung', function ($table)
        {
            if (!DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_buchung', 'buchung_sync_vtyp_synctofeondi_sync_timestamp'))
                $table->index(['sync', 'vtyp', 'synctofeondi', 'sync_timestamp'], 'buchung_sync_vtyp_synctofeondi_sync_timestamp');
        });
    }

    public function down()
    {

    }
}