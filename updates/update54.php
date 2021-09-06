<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update54 extends Migration
{
    protected $modulename = 'update54';

    public function up()
    {
        \DB::update("update xsigns_fewo_obj left join (select objid, max(preis) as preismax, min(preis) as preismin, max(if(preis > 0, bis, '1001-01-01')) as bismax, sum(IF(preis > 0, 1, 0)) as preisanzahl from xsigns_fewo_preise where bis >= now() group by objid) as t1 on t1.objid = xsigns_fewo_obj.id set obj_preismax = ifnull(preismax, 0), obj_preismin = ifnull(preismin, 0), obj_preisbis = ifnull(bismax, '1001-01-01'), obj_preisanzahl = ifnull(preisanzahl, 0)");
    }

    public function down()
    {

    }
}
