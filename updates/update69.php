<?php

namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DatabaseIndexHelper;

class Update69 extends Migration
{
    protected $modulename = 'update69';

    public function up()
    {
        Schema::table('xsigns_fewo_obj', function ($table)
        {
            if (!DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_obj', 'aktiv_preisanzahl'))
                $table->index(['obj_aktiv', 'obj_preisanzahl'], 'aktiv_preisanzahl');
        });
    }

    public function down()
    {

    }
}