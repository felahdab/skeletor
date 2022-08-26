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
            'name' => 'Admin', 
            'prenom' => 'Admin', 
            'date_embarq' => '2022-01-01', 
            'matricule' => '000000000', 
            'email' => 'admin@intradef.gouv.fr',
            'password' => 'admin123',
            'grade_id' => 20,
        ]);
    
        $roles = Role::all()->pluck('name')->all();
     
        $user->syncRoles($roles);
        
        $user = User::create([
            'name' => 'ZA', 
            'prenom' => 'SA', 
            'date_embarq' => '2022-01-01', 
            'matricule' => '000000000', 
            'email' => 'sza@intradef.gouv.fr',
            'password' => 'sza',
            'grade_id' => 20,
        ]);
    
        $roles = Role::all()->pluck('name')->all();
     
        $user->syncRoles($roles);
    }
}