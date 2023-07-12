<?php

namespace Xsigns\Fewo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Update55 extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('xsigns_fewo_zahlungen'))
        {
            Schema::create('xsigns_fewo_zahlungen', function ($table) {
                $table->increments('id');
                $table->integer('za_vorgid')->nullable();
                $table->integer('za_buid')->index();
                $table->decimal('za_anz_betrag');
                $table->date('za_anz_am');
                $table->date('za_anz_gezahlt_am');
                $table->integer('za_anz_gezahlt');
                $table->decimal('za_restz_betrag');
                $table->date('za_restz_am');
                $table->date('za_restz_gezahlt_am');
                $table->integer('za_restz_gezahlt');
                $table->char('za_token');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_zahlungen');
    }
}