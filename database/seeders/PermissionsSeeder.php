<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Artisan::call('mail:send', ['user' => $user, '--queue' => 'default']);
        Artisan::call('permission:create-permission-routes');

        Permission::firstOrCreate(['name' => 'skeletor.recherche-annuaire', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'skeletor.se_faire_passer_pour', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'skeletor.changer_le_mot_de_passe_des_utilisateurs', 'guard_name' => 'web']);
    }
}
