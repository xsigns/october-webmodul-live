<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update72 extends Migration
{
    protected $modulename = 'update72';

    public function up()
    {
        Schema::table('xsigns_fewo_obj', function (Blueprint $table)
        {
            $table->integer('obj_artid')->unsigned()->default(0)->change();
            $table->integer('obj_typid')->unsigned()->default(0)->change();
            $table->integer('obj_ortid')->unsigned()->default(0)->change();
            $table->integer('obj_betten')->unsigned()->default(0)->change();
            $table->integer('obj_personen')->unsigned()->default(0)->change();
            $table->integer('obj_optbelegung')->unsigned()->default(0)->change();
            $table->integer('obj_kinder')->unsigned()->default(0)->change();
            $table->integer('obj_kleinkinder')->unsigned()->default(0)->change();
            $table->integer('obj_erwachsene')->unsigned()->default(0)->change();
            $table->string('obj_etagetext', 100)->default('')->change();
            $table->integer('obj_aktiv')->unsigned()->default(0)->change();
            $table->integer('obj_sterne')->unsigned()->default(0)->change();
            $table->integer('obj_badezimmer')->unsigned()->default(0)->change();
            $table->integer('obj_schlafzimmer')->unsigned()->default(0)->change();
            $table->integer('obj_exclusiv')->unsigned()->default(0)->change();
            $table->integer('obj_userid')->unsigned()->default(0)->change();
            $table->string('obj_strasse', 200)->default('')->change();
            $table->string('obj_ort', 200)->default('')->change();
            $table->integer('obj_regionid')->unsigned()->default(0)->change();
            $table->string('obj_lat', 60)->default('')->change();
            $table->string('obj_lng', 60)->default('')->change();
            $table->string('obj_youtube', 200)->default('')->change();
            $table->string('obj_registriernr', 160)->default('')->change();
            $table->string('obj_buart', 250)->default('')->change();
        });

        Schema::table('xsigns_fewo_vorg', function (Blueprint $table)
        {
            $table->text('vorg_memo')->nullable()->change();
            $table->text('vorg_ehinweis')->nullable()->change();
            $table->decimal('vorg_objpreis', 9, 2)->default(0.00)->change();
            $table->decimal('vorg_leistpreis', 9, 2)->default(0.00)->change();
            $table->decimal('vorg_summe', 9, 2)->default(0.00)->change();
            $table->decimal('vorg_gebuehr', 9, 2)->default(0.00)->change();
            $table->decimal('vorg_kurtaxe', 9, 2)->default(0.00)->change();
            $table->decimal('vorg_anzahlung', 9, 2)->default(0.00)->change();
            $table->decimal('vorg_kaution', 9, 2)->default(0.00)->change();
            $table->decimal('vorg_zuschlag', 9, 2)->default(0.00)->change();
        });
    }

    public function down()
    {

    }
}