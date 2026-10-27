<?php

namespace Xsigns\Fewo\Updates;

use October\Rain\Database\Updates\Migration;
use Xsigns\Fewo\Classes\BillingMigration;

class Update92 extends Migration
{
    public function up()
    {
        BillingMigration::run();
    }

    public function down()
    {
        throw new \RuntimeException('Restore billing documents from the verified private backup.');
    }
}
