<?php

namespace Modules\Transformation\Http\Controllers;

use App\Models\Lien;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index() 
    {
        if(auth()->user())
        {
            $user=auth()->user();
            if ($user->hasRole("2ps"))
                return redirect()->route("statistiques.pour2ps");
            elseif ($user->hasRole("tuteur"))
                return redirect()->route("statistiques.pourtuteurs");
            elseif ($user->hasRole("em"))
                return redirect()->route("statistiques.pourem");
            elseif ($user->hasRole("bord"))
                return redirect()->route("transformation.index");
        }
        $liens= Lien::orderBy('lien_lib')->get();
        $user = auth()->user();
        return view('home.index' , [ 'liens' => $liens , 'user' => $user]);
    }
}