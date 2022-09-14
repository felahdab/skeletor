<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use App\Models\MindefConnectUser;
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
        
        $user = User::where('email', $MCuser->email)->get()->first();
        if ($user != null)
        {
            Auth::login($user);
            return $this->authenticated($request, $user);
        }

        
        // First we remove any entry if any
        MindefConnectUser::where('email', $MCuser->email)->delete();
        
        // The, we create a new entry:

        $user = MindefConnectUser::create([
                'email' => $MCuser->email,
                'name' => $MCuser->user['usual_name'],
                'prenom' => $MCuser->user['usual_forename'],
                'main_department_number' => $MCuser->user['main_department_number'],
                'personal_title'=> $MCuser->user['personal_title'],
                'rank'=> $MCuser->user['rank'],
                'short_rank'=> $MCuser->user['short_rank'],
                'display_name'=> $MCuser->user['display_name'],
            ]);
            
        return view('auth.comebacklater');
    

        $defaultRole = Role::find(2);
        $user->roles()->detach($defaultRole);
        $user->roles()->attach($defaultRole);

        Auth::login($user);

        $userRole = $user->roles[0];
        $request->session()->put('current_role', $userRole->id);
        $request->session()->save();
        return $this->authenticated($request, $user);
    }
    
    public function locallogin(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        
        if (!Auth::validate($credentials))
            return redirect()->to('login')
                    ->withErrors(trans('auth.failed'));
        
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        
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
