<?php namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update24 extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('xsigns_fewo_raum')) {
            Schema::create('xsigns_fewo_raum',function($table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->timestamp('tstamp');
                $table->integer('objid')->unsigned()->index();
                $table->string('raumid',4)->index();
                $table->string('art', 1)->index(); // S=Schlafzimmer, B=Bad
                $table->decimal('groesse',6,2)->default(0.00);
                $table->text('ausst'); // json
            });
        };
        if(!Schema::hasTable('xsigns_fewo_ralang'))
        {
            Schema::create('xsigns_fewo_ralang',function($table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('tstamp');
            $table->integer('objid')->unsigned()->index();
            $table->string('raumid',4)->index();
            $table->string('lang', 3)->index();
            $table->string('titel',160);
            $table->text('beschreibung');
            $table->index(['objid', 'raumid','lang']);
            });
        }

        Schema::table('xsigns_fewo_obj', function($table)
        {
            $table->string('obj_canonical',170)->nullable()->default('')->change();
            $table->string('obj_youtube',120)->nullable()->default('')->change();
            $table->string('obj_lat', 40)->nullable()->change();
            $table->string('obj_lng', 40)->nullable()->change();
            $table->string('obj_ort', 160)->nullable()->change();
            $table->string('obj_strasse', 160)->nullable()->change();
            $table->string('obj_etagetext', 60)->nullable()->change();
            $table->string('obj_intnr', 60)->nullable()->change();
            $table->string('obj_registriernr',100)->default('')->change();
            $table->string('obj_sort', 30)->change();
        });
    }

    public function down()
    {
        
    }
}
