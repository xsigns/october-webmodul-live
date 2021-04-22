<?php

namespace Xsigns\Fewo\Updates;

use Xsigns\Fewo\Models\UserGroup;
use October\Rain\Database\Updates\Seeder;
use DB;
use Schema;

class SeedUserGroupsTable extends Seeder
{
    public function run()
    {
        if (Schema::hasTable('xsigns_owner_user_groups'))
        {
            $group = DB::select("select code from xsigns_owner_user_groups where code='owner'");

            if (!$group) {
                UserGroup::create([
                    'name' => 'Owner',
                    'code' => 'owner',
                    'description' => 'Standard Gruppe für Eigentuemer.'
                ]);
            }
        }
    }
}
