<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class create_ffast_roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'tuteur']);
		$role = Role::create(['name' => 'em']);
		$role = Role::create(['name' => 'transfo']);
		$role = Role::create(['name' => 'bord']);
		$role = Role::create(['name' => '2ps']);
    }
}
