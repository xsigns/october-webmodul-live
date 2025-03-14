<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update38 extends Migration
{
    protected $modulename = 'update38';

    public function up()
    {
        Schema::create('xsigns_fewo_objektbilder', function($table) {
            $table->increments('id');
            $table->timestamp('tstamp')->useCurrent();
            $table->integer('obild_objid')->unsigned()->default(0);
            $table->integer('obild_systemfileid')->unsigned()->default(0);
            $table->string('obild_hash', 32)->default('');
            $table->integer('obild_reihenfolge')->unsigned()->default(0);
            $table->string('obild_titel', 160)->default('');
            $table->string('obild_diskname', 191)->default('');
            $table->string('obild_filename', 191)->default('');

            $table->index(['obild_objid'], 'objid');
            $table->index(['obild_hash'], 'hash');
            $table->index(['obild_objid', 'obild_reihenfolge'], 'objid_reihenfolge');
        });

        \DB::insert("insert into xsigns_fewo_objektbilder (obild_objid, obild_reihenfolge, obild_systemfileid, obild_hash, obild_titel, obild_diskname, obild_filename) select attachment_id, sort_order, id, '', '', disk_name, file_name from system_files where attachment_type = 'objekt'");
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_objektbilder');
    }
}