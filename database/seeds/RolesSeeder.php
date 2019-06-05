<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create_rol("Super Administrator",Permission::select('name')->where('guard_name', 'web')->get()->pluck('name')->toArray());
        $this->create_rol("Provider",["Product","Order","Inventory","Report"]);
        $this->create_rol("Client",["Invoice","Report"]);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();        
    }
    /**
     * Crea el rol y le asigna los permisos.
     * @param string $name Nombre del rol.
     * @param array $modules Conjunto de permisos para el rol.
     * @return void.
     */    
    public function create_rol(string $name,array $modules) :void {    
        $role_admin = Role::create(['guard_name' => 'web','name' => $name]);
        $role_admin->givePermissionTo($modules);
    }
}
