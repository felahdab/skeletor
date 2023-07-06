<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\Artisan;

use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('transformation:rename-transformation-permissions');

        $perm = Permission::where('name', 'statistiques.pourtuteurs')->first();
        $perm->name='transformation::statistiques.statpourunservice';
        $perm->save();

        $perm = Permission::where('name', 'statistiques.pourem')->first();
        $perm->name='transformation::statistiques.statglobal';
        $perm->save();

        $perm = Permission::where('name', 'statistiques.pour2ps')->first();
        $perm->name='transformation::statistiques.statstage';
        $perm->save();

        Permission::where('name', 'stages.choixmarins')->delete();
        Permission::where('name', 'stages.consulter')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
