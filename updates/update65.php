<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DatabaseIndexHelper;

class Update65 extends Migration
{
    protected $modulename = 'update65';

    public function up()
    {
        Schema::table('xsigns_fewo_bew', function ($table)
        {
            if (DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_bew', 'objid_aktiv'))
                $table->dropIndex('objid_aktiv');
        });

        Schema::table('xsigns_fewo_obj', function ($table)
        {
            if (!DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_bew', 'objid_aktiv'))
                $table->index(['obj_aktiv', 'obj_preisbis', 'id'], 'aktiv_preisbis_id');
        });
    }

    public function down()
    {

    }
}