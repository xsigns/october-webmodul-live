<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate8 extends Migration
{
    public function up()
    {

        Schema::create('xsigns_fewo_messages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('tstamp')->useCurrent();
            $table->string('title',200);
            $table->string('lang',3)->index();
            $table->date('fromdate');
            $table->date('todate');
            $table->integer('active');
            $table->text('message');

        });
    }
    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_messages');
    }
}