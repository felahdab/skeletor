<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $role = Role::findOrCreate('admin');
        $rolepermissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($rolepermissions);

        // All users should be assigned the user role, which includes the basic permissions to login, logout, change your
        // own password and your current role.
        $role = Role::findOrCreate('user');
        $rolepermissions = [
            'logout.perform',
        ];
        $role->syncPermissions($rolepermissions);
    }
}
