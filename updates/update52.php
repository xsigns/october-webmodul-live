<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Update52 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_buchung', function($table) {
            $table->integer('synctofeondi');
            $table->integer('sync_timestamp');
        });

        Schema::table('xsigns_fewo_vorg', function($table) {
            $table->char('vorg_buid', 20);
        });
    }

    public function down()
    {
        Schema::table('xsigns_fewo_buchung', function($table) {
            $table->dropColumn('synctofeondi');
            $table->dropColumn('sync_timestamp');
        });

        Schema::table('xsigns_fewo_vorg', function($table) {
            $table->dropColumn('vorg_buid');
        });
    }
}