<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate5 extends Migration
{
    public function up()
    {
        Schema::create('xsigns_fewo_setaus', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100)->index();
            $table->string('ausstattung')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_setaus');
    }
}