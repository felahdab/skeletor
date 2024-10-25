<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $destination = null;

        if ($user) {
            $settings = Arr::get($user->data, "settings", []);

            $destination = Arr::get($settings, 'prefered_page', null);
                        
            if ($destination == null && config('skeletor.page_par_defaut') != '') {
                $destination = config('skeletor.page_par_defaut');
            }

            if ($destination != null && $destination != Route::currentRouteName())
            {
                // On ne redirige que si ce n'est pas vers la route actuelle. Sinon, ça provoque un bouclage.
                // Si la configuration demande a rediriger vers la route actuelle, on ne fait rien, et on sert donc
                // la page d'accueil générale, configurée par ParamAccueil.
                return redirect()->route($destination);
            }
        }
        
        return redirect()->route('login');
    }
}
