<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\URL;

class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform(Request $request)
    {
        Session::flush();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

	$redirectUri = URL::to(route('home.index'));

        return redirect(env('KEYCLOAK_LOGOUT_URL') . $redirectUri ); 
   }
}
