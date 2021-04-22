<?php namespace Xsigns\Fewo\Updates;
use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUpdate6 extends Migration
{
    public function up()
    {

        Schema::table('xsigns_fewo_buchung', function($table)
        {
            $table->integer('tage')->nullable()->unsigned()->default(0);
            $table->dropColumn('hobex_id');
            $table->dropColumn('hobex_gen');
            $table->dropColumn('hobex_stan');
            $table->dropColumn('hobex_kkg');
            $table->dropColumn('hobex_card');
            $table->dropColumn('hobex_txid');
            $table->dropColumn('receiptnumber');
            $table->dropColumn('paypal_id');
            $table->dropColumn('paypal_payername');
            $table->dropColumn('paypal_payerfirstname');
            $table->dropColumn('paypal_payeremail');
            $table->dropColumn('temp_buid');
            $table->dropColumn('temp_zahlid');
            $table->dropColumn('gezahltmit');
            $table->dropColumn('gezahltID');
            $table->dropColumn('gezahltam');
            $table->date('pay_date');
            $table->string('pay_id',200);
        });
    }
    public function down()
    {

    }
}