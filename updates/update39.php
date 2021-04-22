<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update39 extends Migration
{
    protected $modulename = 'update39';

    public function up()
    {
        Schema::table('xsigns_fewo_objaus', function ($table) {
            $table->renameColumn('objid', 'objaus_objid');
            $table->renameColumn('ausid', 'objaus_ausid');
            $table->renameColumn('wert', 'objaus_wert');
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_objaus', function ($table) {
            $table->renameColumn('objaus_objid', 'objid');
            $table->renameColumn('objaus_ausid', 'ausid');
            $table->renameColumn('objaus_wert', 'wert');
        });
    }
}
