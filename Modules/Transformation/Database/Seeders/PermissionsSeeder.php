<?php

namespace Modules\Transformation\Database\Seeders;

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
        Artisan::call('permission:create-permission-routes');
        Artisan::call('permission:create-permission', ['name' => 'transformation::transformation.updatelivret', 'guard' => 'web']);
    }
}
