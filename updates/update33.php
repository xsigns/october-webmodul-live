<?php


namespace Xsigns\Fewo\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class Update33 extends Migration
{
    public function up()
    {
        Schema::table('xsigns_fewo_obj', function($table) {
            $table->decimal('obj_grundstuecksflaeche', 9, 2);
        });

        Schema::create('xsigns_fewo_imagelang', function($table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->timestamp('tstamp');
            $table->string('objid', 4)->index();
            $table->string('lang', 3)->index();
            $table->string('titel', 160);
            $table->text('html');
            $table->index(['objid', 'lang']);
        });

        if (!Schema::hasTable('xsigns_owner_users'))
        {
            Schema::create('xsigns_owner_users', function ($table) {
                $table->engine = 'MyISAM';
                $table->increments('id');
                $table->string('name', 250);
                $table->string('company', 250)->nullable();
                $table->string('surname')->nullable();
                $table->string('street', 250)->nullable();
                $table->string('pcode', 10)->nullable();
                $table->string('city', 250);
                $table->string('country', 3);
                $table->string('phone', 35)->nullable();
                $table->string('mobil', 35)->nullable();
                $table->string('email');
                $table->integer('eid')->unsigned();
                $table->string('password');
                $table->string('activation_code')->nullable()->index();
                $table->string('persist_code')->nullable();
                $table->string('reset_password_code')->nullable()->index();
                $table->text('permissions')->nullable();
                $table->boolean('is_activated')->default(0);
                $table->timestamp('activated_at')->nullable();
                $table->timestamp('last_login')->nullable();
                $table->string('username')->unique();
                $table->boolean('is_superuser')->default(false);
                $table->timestamp('last_seen')->nullable();
                $table->boolean('is_guest')->default(false);
                $table->timestamp('deleted_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('xsigns_owner_user_throttle'))
        {
            Schema::create('xsigns_owner_user_throttle', function ($table) {
                $table->engine = 'MyISAM';
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable()->index();
                $table->string('ip_address')->nullable()->index();
                $table->integer('attempts')->default(0);
                $table->timestamp('last_attempt_at')->nullable();
                $table->boolean('is_suspended')->default(0);
                $table->timestamp('suspended_at')->nullable();
                $table->boolean('is_banned')->default(0);
                $table->timestamp('banned_at')->nullable();
            });
        }

        if (!Schema::hasTable('xsigns_owner_user_groups'))
        {
            Schema::create('xsigns_owner_user_groups', function ($table) {
                $table->engine = 'MyISAM';
                $table->increments('id');
                $table->string('name');
                $table->string('code')->nullable()->index();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('xsigns_owner_users_groups'))
        {
            Schema::create('xsigns_owner_users_groups', function ($table) {
                $table->engine = 'MyISAM';
                $table->integer('user_id')->unsigned();
                $table->integer('user_group_id')->unsigned();
                $table->primary(['user_id', 'user_group_id'], 'user_group');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('xsigns_fewo_imagelang');
        Schema::dropIfExists('xsigns_owner_users');
        Schema::dropIfExists('xsigns_owner_user_throttle');
        Schema::dropIfExists('xsigns_owner_user_groups');
        Schema::dropIfExists('xsigns_owner_users_groups');
    }
}