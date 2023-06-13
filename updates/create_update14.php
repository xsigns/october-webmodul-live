<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate14 extends Migration
{
    public function up()
    {
        Schema::create('xsigns_fewo_ask', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('ask_from');
            $table->date('ask_to');
            $table->string('ask_name', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_ask');
    }
}