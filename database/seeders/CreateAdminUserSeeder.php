<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use App\Service\RandomPasswordGeneratorService;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mot_de_passe = (new RandomPasswordGeneratorService())->generateRandomString(10);

        $user = User::create([
            'nom' => 'Admin', 
            'prenom' => 'Admin', 
            'email' => 'admin@skeletor.fr',
            'password' => $mot_de_passe,
            'display_name' => 'Admin Admin',
            'admin' => true
        ]);
    
        $roles = Role::all()->pluck('name')->all();
     
        $user->syncRoles($roles);
    }
}