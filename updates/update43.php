<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update43 extends Migration
{
    protected $modulename = 'update43';

    public function up()
    {
        Schema::table('xsigns_fewo_aus', function($table) {
            $table->integer('aus_systemfileid')->unsigned();
            $table->string('aus_hash', 32);
            $table->string('aus_diskname', 191);
            $table->string('aus_filename', 191);
        });

        \DB::update("update xsigns_fewo_aus inner join system_files on attachment_id = ausid and attachment_type = 'ausstattung' set aus_systemfileid = attachment_id, aus_diskname = disk_name, aus_filename = file_name");
    }

    public function down()
    {
        Schema::table('xsigns_fewo_aus', function($table) {
            $table->dropColumn('aus_systemfileid');
            $table->dropColumn('aus_hash');
            $table->dropColumn('aus_diskname');
            $table->dropColumn('aus_filename');
        });
    }
}
