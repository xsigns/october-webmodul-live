<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DatabaseIndexHelper;

class Update46 extends Migration
{
    protected $modulename = 'update46';

    public function up()
    {
        Schema::table('xsigns_fewo_obj', function($table) {
            $table->decimal('obj_preismax', 12, 4);
            $table->decimal('obj_preismin', 12, 4);
            $table->date('obj_preisbis');
            $table->integer('obj_preisanzahl');
            $table->index(['obj_preisbis'], 'preisbis');
            $table->index(['obj_aktiv', 'obj_preisbis'], 'aktiv_preisbis');
        });

        \DB::update("update xsigns_fewo_obj inner join (select objid, max(preis) as preismax, min(preis) as preismin, max(if(preis > 0, bis, '1001-01-01')) as bismax, sum(IF(preis > 0, 1, 0)) as preisanzahl from xsigns_fewo_preise where bis >= now() group by objid) as t1 on t1.objid = id set obj_preismax = preismax, obj_preismin = preismin, obj_preisbis = bismax, obj_preisanzahl = preisanzahl");
    }

    public function down()
    {
        Schema::table('xsigns_fewo_obj', function ($table) {
            $table->dropColumn('obj_preismax');
            $table->dropColumn('obj_preismin');
            $table->dropColumn('obj_preisbis');
            $table->dropColumn('obj_preisanzahl');

            if (DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_obj', 'obj_preisbis'))
                $table->dropIndex('obj_preisbis');
            if (DatabaseIndexHelper::checkIfIndexExists('xsigns_fewo_obj', 'aktiv_preisbis'))
                $table->dropIndex('aktiv_preisbis');
        });
    }
}