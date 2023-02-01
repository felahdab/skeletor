<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Artisan;

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
        Artisan::call('permission:create-permission', ['name' => 'changepasswd.allusers', 'guard' => 'web']);
        // Artisan::call('permission:create-permission', ['name' => 'stages.consulter', 'guard' => 'web']);
        // Artisan::call('permission:create-permission', ['name' => 'stages.choixmarins', 'guard' => 'web']);
    }
}
