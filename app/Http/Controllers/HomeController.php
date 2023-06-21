<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index() 
    {
        foreach(Module::allEnabled() as $module)
        {
            $module_home_route = $module->getLowerName() .".homeindex";
            if (Route::has($module_home_route))
            {
                return redirect()->route($module_home_route);
            }
                
        }
        return view('home.index');
    }
}