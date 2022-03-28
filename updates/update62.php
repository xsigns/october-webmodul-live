<?php


namespace Xsigns\Fewo\Updates;

use mysql_xdevapi\Exception;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\Logger;

class Update62 extends Migration
{
    protected $modulename = 'update62';

    public function up()
    {
        Schema::table('xsigns_fewo_obj', function ($table)
        {
            $table->string('id', 20)->default('')->change();
            $table->string('obj_typid', 20)->default('0')->change();
            $table->string('obj_hausid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objaus', function ($table)
        {
            $table->string('objaus_objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objleist', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
            $table->string('leistid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objbleist', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
            $table->string('leistid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objlagen', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objentf', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objza', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objlang', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_preise', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_preiselang', function ($table)
        {
            $table->string('preislng_objid', 20)->default('0')->change();
            $table->string('preislng_preisid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_vorgleist', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
            $table->string('leistid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_vorg', function ($table)
        {
            $table->string('vorg_id', 20)->default('0')->change();
            $table->string('vorg_objid', 50)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objektbilder', function ($table)
        {
            $table->string('obild_objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_imagelang', function ($table)
        {
            $table->string('imglang_objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_angobj', function ($table)
        {
            $table->string('ango_objid', 20)->default('0')->change();
            $table->string('ango_angid', 20)->defautl('0')->change();
        });

        Schema::table('xsigns_fewo_bew', function ($table)
        {
            $table->string('obj_id', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_typ', function ($table)
        {
            $table->string('typid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_typlang', function ($table)
        {
            $table->string('typlang_typid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_reg', function ($table)
        {
            $table->string('regionid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_reglang', function ($table)
        {
            $table->string('reglang_regionid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_le', function ($table)
        {
            $table->string('leistid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_le', function ($table)
        {
            $table->string('leist_artid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_lelang', function ($table)
        {
            $table->string('leistid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_ha', function ($table)
        {
            $table->string('id', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_halang', function ($table)
        {
            $table->string('hausid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_ang', function ($table)
        {
            $table->string('ang_id', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_anglang', function ($table)
        {
            $table->string('angid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_objstat', function ($table)
        {
            $table->string('objid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_buchung', function ($table)
        {
            $table->string('objektid', 20)->default('0')->change();
            $table->string('angebotid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_zu', function ($table)
        {
            $table->string('zu_id', 20)->default('0')->change();
            $table->string('zu_objartid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_zulang', function ($table)
        {
            $table->string('zulng_zuid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_bewopt', function ($table)
        {
            $table->string('id', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_bewoptlang', function ($table)
        {
            $table->string('optionsid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_bewpunkte', function ($table)
        {
            $table->string('bewertung_id', 20)->default('0')->change();
            $table->string('pid', 20)->default('0')->change();
        });

        Schema::table('xsigns_fewo_leart', function ($table)
        {
            $table->string('leistart_id', 20)->default('0')->change();
        });

        if (!Schema::hasColumns('xsigns_fewo_kunde', ['mandantid', 'agb']))
        {
            Schema::table('xsigns_fewo_kunde', function ($table)
            {
                $table->string('mandantid', 20)->default('0');
                $table->text('agb')->nullable();
            });
        }

        if (!Schema::hasColumns('xsigns_fewo_obj', ['obj_preislevel', 'obj_ranking', 'obj_hatkurtaxe']))
        {
            Schema::table('xsigns_fewo_obj', function ($table)
            {
                $table->integer('obj_preislevel')->default(0);
                $table->integer('obj_ranking')->default(0);
                $table->tinyInteger('obj_hatkurtaxe')->default(0);
            });
        }

        if (!Schema::hasColumn('xsigns_fewo_preise', 'mwst'))
        {
            Schema::table('xsigns_fewo_preise', function ($table)
            {
                $table->decimal('mwst', 9, 2)->default(0.00);
            });
        }
    }

    public function down()
    {
        Schema::table('xsigns_fewo_obj', function ($table)
        {
            $table->integer('id', 10)->change();
            $table->integer('obj_typid', 10)->change();
            $table->integer('obj_hausid', 10)->change();
        });

        Schema::table('xsigns_fewo_objaus', function ($table)
        {
            $table->integer('objaus_objid', 10)->change();
        });

        Schema::table('xsigns_fewo_objleist', function ($table)
        {
            $table->integer('objid', 10)->change();
            $table->integer('leistid', 10)->change();
        });

        Schema::table('xsigns_fewo_objbleist', function ($table)
        {
            $table->integer('objid', 10)->change();
            $table->integer('leistid', 10)->change();
        });

        Schema::table('xsigns_fewo_objlagen', function ($table)
        {
            $table->integer('objid', 10)->change();
        });

        Schema::table('xsigns_fewo_objentf', function ($table)
        {
            $table->integer('objid', 10)->change();
        });

        Schema::table('xsigns_fewo_objza', function ($table)
        {
            $table->integer('objid', 10)->change();
        });

        Schema::table('xsigns_fewo_objlang', function ($table)
        {
            $table->integer('objid', 10)->change();
        });

        Schema::table('xsigns_fewo_preise', function ($table)
        {
            $table->integer('objid', 10)->change();
        });

        Schema::table('xsigns_fewo_preiselang', function ($table)
        {
            $table->integer('preislng_objid', 10)->change();
            $table->string('preislng_preisid', 10)->change();
        });

        Schema::table('xsigns_fewo_vorgleist', function ($table)
        {
            $table->integer('objid', 10)->change();
            $table->integer('leistid', 10)->change();
        });

        Schema::table('xsigns_fewo_vorg', function ($table)
        {
            $table->integer('vorg_id', 10)->change();
            $table->integer('vorg_objid', 10)->change();
        });

        Schema::table('xsigns_fewo_objektbilder', function ($table)
        {
            $table->integer('obild_objid', 10)->change();
        });

        Schema::table('xsigns_fewo_imagelang', function ($table)
        {
            $table->integer('imglang_objid', 10)->change();
        });

        Schema::table('xsigns_fewo_angobj', function ($table)
        {
            $table->integer('ango_objid', 10)->change();
            $table->integer('ango_angid', 10)->change();
        });

        Schema::table('xsigns_fewo_bew', function ($table)
        {
            $table->integer('obj_id', 10)->change();
        });

        Schema::table('xsigns_fewo_typ', function ($table)
        {
            $table->integer('typid', 10)->change();
        });

        Schema::table('xsigns_fewo_typlang', function ($table)
        {
            $table->integer('typlang_typid', 10)->change();
        });

        Schema::table('xsigns_fewo_reg', function ($table)
        {
            $table->integer('regionid', 10)->change();
        });

        Schema::table('xsigns_fewo_reglang', function ($table)
        {
            $table->integer('reglang_regionid', 10)->change();
        });

        Schema::table('xsigns_fewo_le', function ($table)
        {
            $table->integer('leistid', 10)->change();
        });

        Schema::table('xsigns_fewo_le', function ($table)
        {
            $table->integer('leist_artid', 10)->change();
        });

        Schema::table('xsigns_fewo_lelang', function ($table)
        {
            $table->integer('leistid', 10)->change();
        });

        Schema::table('xsigns_fewo_ha', function ($table)
        {
            $table->integer('id', 10)->change();
        });

        Schema::table('xsigns_fewo_halang', function ($table)
        {
            $table->integer('hausid', 10)->change();
        });

        Schema::table('xsigns_fewo_ang', function ($table)
        {
            $table->integer('ang_id', 10)->change();
        });

        Schema::table('xsigns_fewo_anglang', function ($table)
        {
            $table->integer('angid', 10)->change();
        });

        Schema::table('xsigns_fewo_objstat', function ($table)
        {
            $table->integer('objid', 10)->change();
        });

        Schema::table('xsigns_fewo_buchung', function ($table)
        {
            $table->integer('objektid', 10)->change();
            $table->integer('angebotid', 10)->change();
        });

        Schema::table('xsigns_fewo_zu', function ($table)
        {
            $table->integer('zu_id', 10)->change();
            $table->integer('zu_objartid', 10)->change();
        });

        Schema::table('xsigns_fewo_zulang', function ($table)
        {
            $table->integer('zulng_zuid', 10)->change();
        });

        Schema::table('xsigns_fewo_bewopt', function ($table)
        {
            $table->integer('id', 10)->change();
        });

        Schema::table('xsigns_fewo_bewoptlang', function ($table)
        {
            $table->integer('optionsid', 10)->change();
        });

        Schema::table('xsigns_fewo_bewpunkte', function ($table)
        {
            $table->integer('bewertung_id', 10)->change();
            $table->integer('pid', 10)->change();
        });

        Schema::table('xsigns_fewo_leart', function ($table)
        {
            $table->integer('leistart_id', 10)->change();
        });

        Schema::table('xsigns_fewo_kunde', function ($table)
        {
            $table->dropColumn(['mandantid', 'agb']);
        });
    }
}
