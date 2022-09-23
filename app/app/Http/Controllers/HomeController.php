<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() 
    {
        return view('home.index');
        if(auth()->user())
        {
            $user=auth()->user();
            if ($user->hasRole("2ps"))
                return redirect()->route("statistiques.pour2ps");
            elseif ($user->hasRole("tuteur"))
                return redirect()->route("statistiques.pourtuteurs");
            elseif ($user->hasRole("em"))
                return redirect()->route("statistiques.pourem");
        }
                
        return view('home.index');
    }
}