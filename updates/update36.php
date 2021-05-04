<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Update36 extends Migration
{
    public function up()
    {
        try
        {
            Schema::table('xsigns_fewo_obj', function($table) {
                $table->index(['obj_land'], 'land');
            });
        }
        catch (\Illuminate\Database\QueryException $e){}

        Schema::table('xsigns_fewo_preise', function($table) {
            $table->index(['objid', 'bis'], 'objid_bis');
            $table->index(['bis'], 'bis');
        });
        Schema::table('xsigns_fewo_bewopt', function($table) {
            $table->index(['id', 'lang'], 'id_lang');
        });
        Schema::table('xsigns_fewo_bew', function($table) {
            $table->index(['obj_id', 'aktiv'], 'objid_aktiv');
            $table->index(['aktiv', 'datum'], 'aktiv_datum');
        });
        Schema::table('xsigns_fewo_vorg', function($table) {
            $table->integer('vorg_is_b_bl_e');
            $table->integer('vorg_is_a_b_bl_e_o');
            $table->index(['vorg_objid', 'vorg_is_a_b_bl_e_o'], 'objid_abbleo');
            $table->index(['vorg_objid', 'vorg_is_b_bl_e'], 'objid_bble');
        });

        \Xsigns\Fewo\Classes\Database::select(null, 'update36', "update xsigns_fewo_vorg set vorg_is_a_b_bl_e_o = 1, vorg_is_b_bl_e = IF(vorg_art = 'A' or vorg_art = 'O', 0, 1)");
    }

    public function down()
    {
        try
        {
            Schema::table('xsigns_fewo_obj', function($table) {
                $table->dropIndex('land');
            });
        }
        catch (\Illuminate\Database\QueryException $e){}

        Schema::table('xsigns_fewo_preise', function($table) {
            $table->dropIndex('objid_bis');
            $table->dropIndex('bis');
        });
        Schema::table('xsigns_fewo_bewopt', function($table) {
            $table->dropIndex('id_lang');
        });
        Schema::table('xsigns_fewo_bew', function($table) {
            $table->dropIndex('objid_aktiv');
            $table->dropIndex('aktiv_datum');
        });
        Schema::table('xsigns_fewo_vorg', function($table) {
            $table->dropColumn('vorg_is_a_b_bl_e_o');
            $table->dropColumn('vorg_is_b_bl_e');
            $table->dropIndex('objid_abbleo');
            $table->dropIndex('objid_bble');
        });
    }
}
