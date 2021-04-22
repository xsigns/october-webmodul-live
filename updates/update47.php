<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update47 extends Migration
{
    protected $modulename = 'update47';

    public function up()
    {
        Schema::table('xsigns_fewo_obj', function ($table) {
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_artid'], 'aktiv_preisbis_artid');
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_schlafzimmer'], 'aktiv_preisbis_schlafzimmer');
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_badezimmer'], 'aktiv_preisbis_badezimmer');
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_ortid'], 'aktiv_preisbis_ortid');
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_ortid', 'obj_schlafzimmer'], 'aktiv_preisbis_ortid_schlafzimmer');
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_ortid', 'obj_badezimmer'], 'aktiv_preisbis_ortid_badezimmer');
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_artid', 'obj_schlafzimmer'], 'aktiv_preisbis_artid_schlafzimmer');
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_artid', 'obj_badezimmer'], 'aktiv_preisbis_artid_badezimmer');
            $table->index(['obj_aktiv', 'obj_preisbis', 'obj_artid', 'obj_ortid'], 'aktiv_preisbis_artid_ortid');
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_obj', function ($table) {
            $table->dropIndex('aktiv_preisbis_artid');
            $table->dropIndex('aktiv_preisbis_schlafzimmer');
            $table->dropIndex('aktiv_preisbis_badezimmer');
            $table->dropIndex('aktiv_preisbis_ortid');
            $table->dropIndex('aktiv_preisbis_ortid_schlafzimmer');
            $table->dropIndex('aktiv_preisbis_ortid_badezimmer');
            $table->dropIndex('aktiv_preisbis_artid_schlafzimmer');
            $table->dropIndex('aktiv_preisbis_artid_badezimmer');
            $table->dropIndex('aktiv_preisbis_artid_ortid');
        });
    }
}
