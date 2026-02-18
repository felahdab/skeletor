<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\URL;

use Laravel\Socialite\Facades\Socialite;

class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return Redirector
     */
    public function perform(Request $request)
    {
        Session::flush();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectUri = URL::to(route('home.index'));

        $KEYCLOAK_CLIENT_ID = config('services.keycloak.client_id');
        $logoutUrl = Socialite::driver('keycloak')
                ->getLogoutUrl(redirectUri: $redirectUri, 
                                clientId: $KEYCLOAK_CLIENT_ID);

        return redirect($logoutUrl);
   }
}
