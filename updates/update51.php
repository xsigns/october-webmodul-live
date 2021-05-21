<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update51 extends Migration
{
    public function up()
    {
        \DB::delete("delete from xsigns_fewo_gast");
    }

    public function down(){}
}