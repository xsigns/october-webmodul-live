<?php

namespace Xsigns\Fewo\Updates;

use DB;
use October\Rain\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\Database;

class Update76 extends Migration
{
    protected string $modulename = 'update76';

    private string $bewTable = 'xsigns_fewo_bew';
    private string $bewPunkteTable = 'xsigns_fewo_bewpunkte';
    private string $fremdIdColumn = 'fremd_id';

    public function up()
    {
        if (Schema::hasTable($this->bewTable) && !Schema::hasColumn($this->bewTable, $this->fremdIdColumn))
        {
            Schema::table($this->bewTable, function (Blueprint $table)
            {
                $table->string($this->fremdIdColumn, 50)->default('0');
            });
        }

        if (Schema::hasTable($this->bewPunkteTable) && !Schema::hasColumn($this->bewPunkteTable, $this->fremdIdColumn))
        {
            Schema::table($this->bewPunkteTable, function (Blueprint $table)
            {
                $table->string($this->fremdIdColumn, 50)->default('0');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable($this->bewTable) && Schema::hasColumn($this->bewTable, $this->fremdIdColumn))
        {
            Schema::table($this->bewTable, function (Blueprint $table)
            {
                $table->dropColumn($this->fremdIdColumn);
            });
        }

        if (Schema::hasTable($this->bewPunkteTable) && Schema::hasColumn($this->bewPunkteTable, $this->fremdIdColumn))
        {
            Schema::table($this->bewPunkteTable, function (Blueprint $table)
            {
                $table->dropColumn($this->fremdIdColumn);
            });
        }
    }
}