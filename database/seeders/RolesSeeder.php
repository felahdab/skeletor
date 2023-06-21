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
        $role = Role::findOrCreate('admin');
        $rolepermissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($rolepermissions);

        // All users should be assigned the user role, which includes the basic permissions to login, logout, change your
        // own password and your current role.
        $role = Role::findOrCreate('user');
        $rolepermissions = [
            'logout.perform',
            'currentrole.show',
            'currentrole.store',
            'changepasswd.show',
            'changepasswd.store',
            'bugreports.store',
        ];
        $role->syncPermissions($rolepermissions);
    }
}
