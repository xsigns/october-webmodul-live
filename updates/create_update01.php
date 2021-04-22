<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_vorg', function($table)
        {
            $table->decimal('vorg_zuschlag',9,2)->nullable()->default(0.00);
             $table->integer('vorg_meldeschein')->nullable()->unsigned()->default(0);
        });

        Schema::create('xsigns_fewo_vorgmit', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('gastid')->unsigned()->index();
            $table->integer('vorgid')->unsigned()->index();
            $table->string('vorname', 30)->nullable();
            $table->string('name', 30)->nullable();
            $table->date('geb');
        }
        );
    }

    public function down()
    {
        Schema::table('xsigns_fewo_vorg', function($table)
        {
            $table->dropColumn('vorg_zuschlag');
        });

    }

}