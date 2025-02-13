<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate18 extends Migration
{
    public function up()
    {
        Schema::create('xsigns_fewo_vorgzahl', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('tstamp')->useCurrent();
            $table->integer('vorgid')->unsigned()->index();
            $table->string('art',100);
            $table->string('text',220);
            $table->decimal('betrag', 9, 2)->default(0.00);
            $table->date('datum')->index();
            $table->date('erfasst');
            $table->index(['vorgid', 'art']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_vorgzahl');
    }
}