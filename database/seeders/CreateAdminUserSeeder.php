<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nom' => 'Admin', 
            'prenom' => 'Admin', 
            'email' => 'admin@intradef.gouv.fr',
            'password' => 'admin123',
            'display_name' => 'Admin Admin',
            'admin' => true
        ]);
    
        $roles = Role::all()->pluck('name')->all();
     
        $user->syncRoles($roles);
    }
}