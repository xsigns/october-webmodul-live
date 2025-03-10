<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate22 extends Migration
{
    public function up()
    {
        Schema::create('xsigns_fewo_raum',function($table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('tstamp')->useCurrent();
            $table->integer('objid')->unsigned()->index();
            $table->string('raumid',4)->index();
            $table->string('art', 1)->index(); // S=Schlafzimmer, B=Bad
            $table->decimal('groesse',6,2)->default(0.00);
            $table->text('ausst'); // json
        });
        Schema::create('xsigns_fewo_ralang',function($table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('tstamp')->useCurrent();
            $table->integer('objid')->unsigned()->index();
            $table->string('raumid',4)->index();
            $table->string('lang', 3)->index();
            $table->string('titel',160);
            $table->text('beschreibung');
            $table->index(['objid', 'raumid','lang']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_raum');
        Schema::dropIfExists('xsigns_fewo_ralang');
    }
}