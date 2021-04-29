<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Update49 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_vorg', function($table) {
            $table->dropColumn('vorg_is_b_bl_e');
            $table->dropColumn('vorg_is_a_b_bl_e_o');
            $table->dropIndex('objid_abbleo');
            $table->dropIndex('objid_bble');
            $table->integer('vorg_is_b_bl_e');
            $table->integer('vorg_is_a_b_bl_e_o');
            $table->index(['vorg_objid', 'vorg_is_a_b_bl_e_o'], 'objid_abbleo');
            $table->index(['vorg_objid', 'vorg_is_b_bl_e'], 'objid_bble');
        });

        \Xsigns\Fewo\Classes\Database::select(null, 'update36', "update xsigns_fewo_vorg set vorg_is_a_b_bl_e_o = 1, vorg_is_b_bl_e = IF(vorg_art = 'A' or vorg_art = 'O', 0, 1)");
    }

    public function down()
    {
        Schema::table('xsigns_fewo_vorg', function($table) {
            $table->dropColumn('vorg_is_a_b_bl_e_o');
            $table->dropColumn('vorg_is_b_bl_e');
            $table->dropIndex('objid_abbleo');
            $table->dropIndex('objid_bble');
            $table->string('vorg_is_b_bl_e');
            $table->string('vorg_is_a_b_bl_e_o');
            $table->index(['vorg_objid', 'vorg_is_a_b_bl_e_o'], 'objid_abbleo');
            $table->index(['vorg_objid', 'vorg_is_b_bl_e'], 'objid_bble');
        });
    }
}