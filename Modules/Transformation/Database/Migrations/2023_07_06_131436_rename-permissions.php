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
        # On renomme toutes les permissions correspondant à une ancienne route
        Artisan::call('transformation:rename-transformation-permissions');

        # On supprime 2 permissions devenues inutiles
        Permission::where('name', 'stages.choixmarins')->delete();
        Permission::where('name', 'stages.consulter')->delete();

        # On renomme quelques permissions dont la route a change de nom, ou qui ne sont pas associees a une route.
        $perm = Permission::where('name', 'statistiques.pourtuteurs')->first();
        if ($perm) {
            $perm->name = 'transformation::statistiques.statpourunservice';
            $perm->save();
        }

        $perm = Permission::where('name', 'statistiques.pourem')->first();
        if ($perm) {
            $perm->name = 'transformation::statistiques.statglobal';
            $perm->save();
        }

        $perm = Permission::where('name', 'statistiques.pour2ps')->first();
        if ($perm) {
            $perm->name = 'transformation::statistiques.statstage';
            $perm->save();
        }

        $perm = Permission::where('name', 'transformation.validerlacheoudouble')->first();
        if ($perm) {
            $perm->name = 'transformation::transformation.validerlacheoudouble';
            $perm->save();
        }

        $perm = Permission::where('name', 'transformation.updatelivret')->first();
        if ($perm) {
            $perm->name = 'transformation::transformation.updatelivret';
            $perm->save();
        }
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
