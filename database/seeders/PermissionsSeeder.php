<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Artisan;

use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Artisan::call('mail:send', ['user' => $user, '--queue' => 'default']);
        Artisan::call('permission:create-permission-routes');

        Permission::firstOrCreate(["name" => "skeletor.recherche-annuaire", "guard_name" => "web"]);
        
    }
}
