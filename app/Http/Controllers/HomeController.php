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
        if ($user != null) {
            $preferedroute = $user->settings()->get('prefered_page');

            if ($preferedroute != null) {
                return redirect()->route($preferedroute);
            }
        }
        $paramaccueil = Paramaccueil::firstOrCreate([
            'paramaccueil_image' => ' 11.jpg',
            'paramaccueil_texte' => 'le texte est modifiable'
        ]);

        return view('home.index',['paramaccueil' => $paramaccueil]);
    }
}
