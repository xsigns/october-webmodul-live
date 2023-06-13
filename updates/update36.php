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

        \DB::update("update xsigns_fewo_vorg set vorg_is_a_b_bl_e_o = 1, vorg_is_b_bl_e = IF(vorg_art = 'A' or vorg_art = 'O', 0, 1)");
    }

    public function down()
    {
        try
        {
            Schema::table('xsigns_fewo_obj', function($table) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails('xsigns_fewo_obj');

                if ($doctrineTable->hasIndex('land'))
                    $table->dropIndex('land');
            });
        }
        catch (\Illuminate\Database\QueryException $e){}

        Schema::table('xsigns_fewo_preise', function($table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('xsigns_fewo_preise');

            if ($doctrineTable->hasIndex('objid_bis'))
                $table->dropIndex('objid_bis');
            if ($doctrineTable->hasIndex('bis'))
                $table->dropIndex('bis');
        });
        Schema::table('xsigns_fewo_bewopt', function($table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('xsigns_fewo_bewopt');

            if ($doctrineTable->hasIndex('id_lang'))
                $table->dropIndex('id_lang');
        });
        Schema::table('xsigns_fewo_bew', function($table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('xsigns_fewo_bew');

            if ($doctrineTable->hasIndex('objid_aktiv'))
                $table->dropIndex('objid_aktiv');
            if ($doctrineTable->hasIndex('aktiv_datum'))
                $table->dropIndex('aktiv_datum');
        });
        Schema::table('xsigns_fewo_vorg', function($table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('xsigns_fewo_vorg');

            if ($doctrineTable->hasIndex('vorg_is_a_b_bl_e_o'))
                $table->dropColumn('vorg_is_a_b_bl_e_o');
            if ($doctrineTable->hasIndex('vorg_is_b_bl_e'))
                $table->dropColumn('vorg_is_b_bl_e');
            if ($doctrineTable->hasIndex('objid_abbleo'))
                $table->dropIndex('objid_abbleo');
            if ($doctrineTable->hasIndex('objid_bble'))
                $table->dropIndex('objid_bble');
        });
    }
}
