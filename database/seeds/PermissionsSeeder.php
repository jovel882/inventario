<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['guard_name' => 'web','name' => 'Product']);
        Permission::create(['guard_name' => 'web','name' => 'Order']);
        Permission::create(['guard_name' => 'web','name' => 'Invoice']);
        Permission::create(['guard_name' => 'web','name' => 'Inventory']);
        Permission::create(['guard_name' => 'web','name' => 'Report']);
    }
}
