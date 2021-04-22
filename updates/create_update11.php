<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate11 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_vorg', function($table)
        {
            $table->string('vorg_kennzeichen',100)->nullable();
        });

        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->string('kennzeichen',100)->nullable();
        });

    }

    public function down()
    {
        Schema::table('xsigns_fewo_vorg', function($table)
        {
            $table->dropColumn('vorg_kennzeichen');
        });
        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->dropColumn('kennzeichen');
        });

    }

}