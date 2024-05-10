<?php

namespace App\Http\Controllers;

use App\Models\Paramaccueil;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Nwidart\Modules\Facades\Module;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user) {
            $destination = $user->settings()->get('prefered_page');
            
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

        $paramaccueil = Paramaccueil::first();
        if (!$paramaccueil) {
            $paramaccueil = new Paramaccueil;
            $paramaccueil->paramaccueil_image = '11.jpg';
            $paramaccueil->paramaccueil_texte = 'le texte est modifiable';
            $paramaccueil->save();
        }
        return view('home.index', ['paramaccueil' => $paramaccueil]);
    }
}
