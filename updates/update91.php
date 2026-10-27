<?php

namespace Xsigns\Fewo\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;
use DB;

class Update91 extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('xsigns_fewo_rest_attempts')) {
            Schema::create('xsigns_fewo_rest_attempts', function ($table) {
                $table->increments('id');
                $table->unsignedInteger('payment_id')->index();
                $table->integer('booking_id');
                $table->string('merchant_transaction_id', 100)->unique();
                $table->string('provider_payment_id', 100)->default('');
                $table->string('registration_id', 191)->default('');
                $table->string('entity_id', 100)->default('');
                $table->boolean('test_mode');
                $table->decimal('amount', 10, 2);
                $table->string('status', 20)->default('unknown');
                $table->string('result_code', 20)->default('');
                $table->string('message', 255)->default('');
                $table->string('actor', 100)->default('');
                $table->timestamp('checked_at')->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('xsigns_fewo_rest_checks')) {
            Schema::create('xsigns_fewo_rest_checks', function ($table) {
                $table->increments('id');
                $table->unsignedInteger('attempt_id')->index();
                $table->string('actor', 100);
                $table->string('status', 20);
                $table->string('result_code', 20)->default('');
                $table->string('message', 255);
                $table->timestamp('created_at');
            });
        }
        DB::table('xsigns_fewo_zahlungen')->where('za_restz_receiptnumber', '!=', '')
            ->orderBy('id')->chunk(100, function ($payments) {
                foreach ($payments as $payment) {
                    if (DB::table('xsigns_fewo_rest_attempts')->where('merchant_transaction_id', $payment->za_restz_receiptnumber)->exists()) {
                        continue;
                    }
                    DB::table('xsigns_fewo_rest_attempts')->insert([
                        'payment_id' => $payment->id, 'booking_id' => $payment->za_buid,
                        'merchant_transaction_id' => $payment->za_restz_receiptnumber,
                        'provider_payment_id' => $payment->za_restz_payid,
                        'registration_id' => $payment->za_token,
                        'entity_id' => '', 'test_mode' => false,
                        'amount' => $payment->za_restz_betrag,
                        'status' => $payment->za_restz_gezahlt ? 'success' : 'unknown',
                        'message' => 'Historischer Versuch; Händlerkontext muss manuell geprüft werden.',
                        'actor' => 'Migration',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            });
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_rest_checks');
        Schema::dropIfExists('xsigns_fewo_rest_attempts');
    }
}
