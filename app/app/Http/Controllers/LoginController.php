<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    /**
     * Display login page.
     * 
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
	$MCuser = Socialite::driver('keycloak')->stateless()->user();

	ddd($MCuser);

	$user = User::updateOrCreate([
            'email' => $MCuser->email,
        ], [
          'name' => $MCuser->user['usual_name'],
          'prenom' => $MCuser->user['usual_forename'],
          'password' => 'toto',
        ]);

        $defaultRole = Role::find(2);
        $user->roles()->detach($defaultRole);
        $user->roles()->attach($defaultRole);

	Auth::login($user);

        $userRole = $user->roles[0];
        $request->session()->put('current_role', $userRole->id);
        $request->session()->save();
        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user) 
    {
        return redirect()->intended();
    }
}
