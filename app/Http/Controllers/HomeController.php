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
        $destination = null;

        if ($user) {
            $destination = $user->settings()->get('prefered_page');

        }

        if ($destination == null) {
            $destination = config('skeletor.page_par_defaut');
        }
        if ($destination != Route::currentRouteName()) {
            return redirect()->route(config('skeletor.page_par_defaut'));
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
