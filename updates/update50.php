<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update50 extends Migration
{
    public function up()
    {
        Database::select(null, 'update50', "update xsigns_fewo_obj inner join (select objid, max(preis) as preismax, min(preis) as preismin, max(if(preis > 0, bis, '1001-01-01')) as bismax, sum(IF(preis > 0, 1, 0)) as preisanzahl from xsigns_fewo_preise where bis >= now() group by objid) as t1 on t1.objid = id set obj_preismax = preismax, obj_preismin = preismin, obj_preisbis = bismax, obj_preisanzahl = preisanzahl");
    }

    public function down(){}
}