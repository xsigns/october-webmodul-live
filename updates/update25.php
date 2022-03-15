<?php namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update25 extends Migration
{
    public function up()
    {
        Schema::create('xsigns_fewo_images',function($table){
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->timestamp('tstamp');
            $table->integer('fewoid')->unsigned()->index();
            $table->string('typ',1)->index(); // O = Objekt, H= Haus, A = Ausstattung, G = Grundrisse
            $table->integer('no')->unsigned()->index();
            $table->string('image',250);
            $table->string('title',250);
            $table->text('description');
            $table->index(['fewoid', 'typ']);
        });
    }

    public function down()
    {


    }

}
