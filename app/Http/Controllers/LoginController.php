<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use App\Models\MindefConnectUser;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

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
        $driver = Socialite::driver('keycloak');
        $driver->setHttpClient(new Client(["verify" => false]));

        $MCuser = $driver->stateless()->user();
        
        $user = User::where('email', $MCuser->email)->get()->first();
        if ($user != null) {
            Auth::login($user);
            return $this->authenticated($request, $user);
        }
        $MCuserexist = MindefConnectUser::where('email', $MCuser->email)->get()->first();
        if($MCuserexist){
            $MCuserexist->updated_at = date('Y-m-d G:i:s');
            $MCuserexist->msg = true;
        }
        else{
            $MCuserexist = MindefConnectUser::create(
                [
                    'sub' => $MCuser->user['sub'],
                    'email' => $MCuser->email,
                    'name' => $MCuser->user['usual_name'],
                    'prenom' => $MCuser->user['usual_forename'],
                    'main_department_number' => $MCuser->user['main_department_number'],
                    'personal_title'=> $MCuser->user['personal_title'],
                    'rank'=> $MCuser->user['rank'],
                    'short_rank'=> $MCuser->user['short_rank'],
                    'display_name'=> $MCuser->user['display_name'],
                ]
            );    
        }

        return view('auth.comebacklater',['MCuserexist'=>$MCuserexist]);
    }

    public function newMdcLogin(Request $request, MindefConnectUser $MCuserexist)
    {
        //enregistrer le commentaire
        $MCuserexist->commentaire=$request->comment_mdconnect;
        $MCuserexist->save();

        $response = Http::withoutVerifying()
            ->withHeaders(["X-Auth-AccessKey" => env("TULEAP_TOKEN")])
            ->post(
                env("TULEAP_URL") . "api/artifacts", [
                "tracker" =>  ["id" => env('TULEAP_TRACKER_MINDEFCONNECT') ],
                "values_by_field" => [
                    "affectation"=>  ["value"  => $MCuserexist->main_department_number ],
                    "user"=> ["value" => $MCuserexist->display_name] ,
                    "raison" => ["value" => $MCuserexist->commentaire] ,
                    "instance" => ["value" => env("APP_PREFIX") ]
                ]
                ]
            );

        return view('home.index');            
    }
    
    public function locallogin(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        
        if (!Auth::validate($credentials)) {
            return redirect()->to(route('login.show'))
                ->withErrors(trans('auth.failed'));
        }
        
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        
        Auth::login($user);
        if ($user->roles->count() != 0) {;    
            $userRole = $user->roles[0];
            $request->session()->put('current_role', $userRole->id);
            $request->session()->save();
        }
        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth    $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user) 
    {
        return redirect()->route('home.index');
    }
}
