<?php

namespace Modules\Transformation\Http\Controllers;

use App\Models\Lien;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $preferedroute = $user->settings()->get('transformation.pageaccueil');

        if ($preferedroute == 'transformation::transformation.homeindex' || $preferedroute == null) {
            $liens = Lien::orderBy('lien_lib')->get();
            $user = auth()->user();
            return view('transformation::home.index', ['liens' => $liens, 'user' => $user]);
        }
        if ($preferedroute != null) {
            return redirect()->route($preferedroute);
        }
    }
}
