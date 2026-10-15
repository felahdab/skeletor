<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $destination = null;

        if ($user) {
            $destination = $user->getPreference('skeletor', 'prefered_page');

            if (null == $destination && '' != config('skeletor.page_par_defaut')) {
                $destination = config('skeletor.page_par_defaut');
            }

            if (null != $destination && $destination != Route::currentRouteName()) {
                // On ne redirige que si ce n'est pas vers la route actuelle. Sinon, ça provoque un bouclage.
                // Si la configuration demande a rediriger vers la route actuelle, on ne fait rien, et on sert donc
                // la page d'accueil générale, configurée par ParamAccueil.
                return redirect()->route($destination);
            }
        }

        $destination = config('skeletor.page_par_defaut');
        if (null != $destination && $destination != Route::currentRouteName()) {
            // On ne redirige que si ce n'est pas vers la route actuelle. Sinon, ça provoque un bouclage.
            // Si la configuration demande a rediriger vers la route actuelle, on ne fait rien, et on sert donc
            // la page d'accueil générale, configurée par ParamAccueil.
            return redirect()->route($destination);
        }

        return redirect()->route('login');
    }
}
