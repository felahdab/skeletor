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

        $user = auth()->user();
        if ($user != null) {
            $preferedroute = $user->settings()->get('prefered_page');

            if ($preferedroute != null) {
                return redirect()->route($preferedroute);
            }
        }

        return view('home.index');
    }
}
