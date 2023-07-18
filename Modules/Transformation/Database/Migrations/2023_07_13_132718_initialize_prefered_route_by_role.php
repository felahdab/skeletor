<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (User::all() as $user) {
            if ($user->hasRole("2ps"))
                $user->settings()->set('transformation.pageaccueil', 'transformation::statistiques.statstage');
            elseif ($user->hasRole("tuteur"))
                $user->settings()->set('transformation.pageaccueil', "transformation::statistiques.statpourunservice");
            elseif ($user->hasRole("em"))
                $user->settings()->set('transformation.pageaccueil', "transformation::statistiques.statglobal");
            elseif ($user->hasRole("bord"))
                $user->settings()->set('transformation.pageaccueil', "transformation::transformation.index");
            else
                $user->settings()->set('transformation.pageaccueil', 'transformation::transformation.homeindex');
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
