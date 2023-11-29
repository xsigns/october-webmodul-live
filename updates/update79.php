<?php

namespace Xsigns\Fewo\Updates;

use DateTime;
use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\FewoDatum;
use Xsigns\Fewo\Classes\Objekt;

class Update79 extends Migration
{
    protected string $modulename = 'update79';

    public function up()
    {
        if (!Schema::hasTable('xsigns_fewo_objsuchindex'))
        {
            Schema::create('xsigns_fewo_objsuchindex', function (Blueprint $table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('objsuchindex_objid', 20)->default('0')->index('objsuchindex_objid');
                $table->text('objsuchindex_wechselleiste')->nullable();
                $table->text('objsuchindex_verfuegbarleiste')->nullable();
                $table->text('objsuchindex_mintageleiste')->nullable();
                $table->text('objsuchindex_lueckbuchungleiste')->nullable();
                $table->date('objsuchindex_leisteab')->default('1001-01-01');
                $table->string('objsuchindex_ausst', 768)->default('');
            });
        }

        if (!Schema::hasTable('xsigns_fewo_buchungsluecken'))
        {
            Schema::create('xsigns_fewo_buchungsluecken', function (Blueprint $table)
            {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('bl_objid', 20)->default('0')->index('bl_objid');
                $table->date('bl_von')->default('1001-01-01');
                $table->date('bl_bis')->default('1001-01-01');
                $table->integer('bl_monat')->unsigned()->default(0);
                $table->integer('bl_jahr')->unsigned()->default(0);
            });
        }

        $aktuellesJahr = date('Y', time());
        $dateErsterMonat = new DateTime($aktuellesJahr . '-01-01');

        $diffMonths = ((int)date('n', time())) - 1;

        $objekte = Database::select(null, $this->modulename, "select id, obj_name, coalesce(group_concat(objaus_ausid separator ';'), '') as obj_ausst from xsigns_fewo_obj left join xsigns_fewo_objaus on id = objaus_objid group by id");

        foreach ($objekte as $objekt)
        {
            // Create and store timelines
            $objZeitleiste = Objekt::createZeitleiste2(null, $this->modulename, $objekt->id, - $diffMonths);

            $wechselleiste = $objZeitleiste[0]->wechselleiste;
            $verfuegbarleiste = $objZeitleiste[0]->verfuegbarleiste;
            $mintageleiste = $objZeitleiste[0]->mintageleiste;
            $lueckbuchungleiste = $objZeitleiste[0]->lueckenbuchungleiste;

            Database::execute(null, $this->modulename, "insert into xsigns_fewo_objsuchindex (objsuchindex_objid, objsuchindex_wechselleiste, objsuchindex_verfuegbarleiste, objsuchindex_mintageleiste, objsuchindex_lueckbuchungleiste, objsuchindex_leisteab, objsuchindex_ausst) values (:objsuchindex_objid, :objsuchindex_wechselleiste, :objsuchindex_verfuegbarleiste, :objsuchindex_mintageleiste, :objsuchindex_lueckbuchungleiste, :objsuchindex_leisteab, :objsuchindex_ausst)", [
                'objsuchindex_objid' => $objekt->id,
                'objsuchindex_wechselleiste' => $wechselleiste,
                'objsuchindex_verfuegbarleiste' => $verfuegbarleiste,
                'objsuchindex_mintageleiste' => $mintageleiste,
                'objsuchindex_lueckbuchungleiste' => $lueckbuchungleiste,
                'objsuchindex_leisteab' => $dateErsterMonat->format('Y-m-d'),
                'objsuchindex_ausst' => $objekt->obj_ausst != '' ? ';' . $objekt->obj_ausst . ';' : ''
            ]);

            // Search and store booking gaps
            preg_match_all('/XIX*OX/', $wechselleiste, $matches, PREG_OFFSET_CAPTURE);

            if (count($matches[0]))
            {
                $mintageArr = explode(';', $mintageleiste);

                foreach ($matches[0] as $match)
                {
                    $matchPosition = $match[1];
                    $mintage = $mintageArr[$matchPosition + 1];
                    $lbok = substr($lueckbuchungleiste, $match[1] + 1, 1);
                    $luecke = substr($match[0], 1, -1);
                    $lueckeLength = strlen($luecke) - 1;

                    if ($lbok && $lueckeLength < $mintage)
                    {
                        $startDateLeiste = new FewoDatum($dateErsterMonat->format('Y-m-d'));

                        $von = (new FewoDatum($startDateLeiste))->addDays($match[1] + 1);
                        $bis = (new FewoDatum($von))->addDays($lueckeLength);
                        $month = date('n', $von->getTimestamp());
                        $year = date('Y', $von->getTimestamp());

                        Database::execute(null, $this->modulename, "insert into xsigns_fewo_buchungsluecken (bl_objid, bl_von, bl_bis, bl_monat, bl_jahr) values (:bl_objid, :bl_von, :bl_bis, :bl_monat, :bl_jahr)", [
                            'bl_objid' => $objekt->id,
                            'bl_von' => $von->getDatumUS(),
                            'bl_bis' => $bis->getDatumUS(),
                            'bl_monat' => $month,
                            'bl_jahr' => $year,
                        ]);
                    }
                }
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_objsuchindex');
        Schema::dropIfExists('xsigns_fewo_buchungsluecken');
    }
}