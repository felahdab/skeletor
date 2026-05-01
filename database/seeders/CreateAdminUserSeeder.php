<?php

namespace Database\Seeders;

use App\Models\User;
use App\Service\RandomPasswordGeneratorService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $currentAdmin = User::where("email", "admin@skeletor.fr")->first();

        if (null == $currentAdmin)
        {
            $mot_de_passe = (new RandomPasswordGeneratorService())->generateRandomString(10);

            $user = User::create([
                'email' => 'admin@skeletor.fr',
                'nom' => 'Admin',
                'prenom' => 'Admin',
                'password' => $mot_de_passe,
                'display_name' => 'Admin Admin',
                'admin' => true,
            ]);

            echo "Admin user created with password: {$mot_de_passe}\n";
        }
        
    }
}
