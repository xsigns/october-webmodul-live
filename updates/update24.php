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

        /*$tables = [
            'system_files',
            'xsigns_fewo_abrechnung',
            'xsigns_fewo_ang',
            'xsigns_fewo_anglang',
            'xsigns_fewo_angobj',
            'xsigns_fewo_art',
            'xsigns_fewo_artlang',
            'xsigns_fewo_ask',
            'xsigns_fewo_aus',
            'xsigns_fewo_auskat',
            'xsigns_fewo_auskatlang',
            'xsigns_fewo_auslang',
            'xsigns_fewo_bew',
            'xsigns_fewo_bewopt',
            'xsigns_fewo_bewoptlang',
            'xsigns_fewo_bewpunkte',
            'xsigns_fewo_buchung',
            'xsigns_fewo_entf',
            'xsigns_fewo_entflang',
            'xsigns_fewo_galleries',
            'xsigns_fewo_gast',
            'xsigns_fewo_ha',
            'xsigns_fewo_halang',
            'xsigns_fewo_kunde',
            'xsigns_fewo_la',
            'xsigns_fewo_lalang',
            'xsigns_fewo_le',
            'xsigns_fewo_leart',
            'xsigns_fewo_lelang',
            'xsigns_fewo_messages',
            'xsigns_fewo_obj',
            'xsigns_fewo_objaus',
            'xsigns_fewo_objbleist',
            'xsigns_fewo_objentf',
            'xsigns_fewo_objlagen',
            'xsigns_fewo_objlang',
            'xsigns_fewo_objleist',
            'xsigns_fewo_objstat',
            'xsigns_fewo_objza',
            'xsigns_fewo_orte',
            'xsigns_fewo_preise',
            'xsigns_fewo_preiselang',
            'xsigns_fewo_ralang',
            'xsigns_fewo_raum',
            'xsigns_fewo_reg',
            'xsigns_fewo_reglang',
            'xsigns_fewo_reinfirma',
            'xsigns_fewo_setaus',
            'xsigns_fewo_slide_shows',
            'xsigns_fewo_typ',
            'xsigns_fewo_typlang',
            'xsigns_fewo_vorggesendet',
            'xsigns_fewo_vorg',
            'xsigns_fewo_vorgleist',
            'xsigns_fewo_vorgmit',
            'xsigns_fewo_vorgzahl',
            'xsigns_fewo_zu',
            'xsigns_fewo_zulang',
            'system_event_logs',
            'system_settings'
        ];

        foreach ($tables as $table) {
            DB::statement('ALTER TABLE ' . $table . ' ENGINE = MyISAM');
        }*/
    }

    public function down()
    {}
}
