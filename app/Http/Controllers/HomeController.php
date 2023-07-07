<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Nwidart\Modules\Facades\Module;

class HomeController extends Controller
{
    public function index()
    {   
        if (Auth::check()) {
            foreach (Module::allEnabled() as $module) {
                $module_home_route = $module->getLowerName() . "::" . $module->getLowerName() . ".homeindex";
                if (Route::has($module_home_route)) {
                    return redirect()->route($module_home_route);
                }
            }
        }
        
        return view('home.index');
    }
}
