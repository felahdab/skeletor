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
            $preferedroute = $user->settings()->get('prefered_page');

            if ($preferedroute != null) {
                return redirect()->route($preferedroute);
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

        return redirect()->route(config('skeletor.page_par_defaut'));
    }
}
