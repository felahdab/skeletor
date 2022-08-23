<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        // All users should be assigned the user role, which includes the basic permissions to login, logout, change your
        // own password and your current role.
        $role = Role::create(['name' => 'user']);
        $defaultpermissions = ['home.index', 'login.show', 'login.perform', 'logout.perform', 
                    'currentrole.show', 'currentrole.store', 
                    'changepasswd.show', 'changepasswd.store',];
        $role->syncPermissions($defaultpermissions);
        
        $role = Role::create(['name' => 'tuteur']);
        $role = Role::create(['name' => 'em']);
        $role = Role::create(['name' => 'transfo']);
        $role = Role::create(['name' => 'bord']);
        $role = Role::create(['name' => '2ps']);
        
    }
}
