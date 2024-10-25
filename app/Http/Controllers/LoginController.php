<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use App\Models\Grade;
use Spatie\Permission\Models\Role;
use App\Models\MindefConnectUser;
use App\Models\Paramaccueil;

use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Service\PossibleUniteService;


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

        //ddd($MCuser);

        $user = User::where('email', $MCuser->email)->get()->first();
        if ($user != null) {
            $user->storeMindefConnectInformations($MCuser->user);
            Auth::login($user);
            return $this->authenticated($request, $user);
        }

        //dd($MCuser);
        // SocialiteProviders\Manager\OAuth2\User {#2604 ▼ // app/Http/Controllers/LoginController.php:59
        //     +id: "fae19bae-fc72-4c93-9dbf-d7d5fc135455"
        //     +nickname: "f.el-ahdab"
        //     +name: "Florian El-Ahdab"
        //     +email: "florian.el-ahdab@adalfantln.marine.defensecdd.gouv.fr"
        //     +avatar: null
        //     +user: array:7 [▼
        //       "sub" => "fae19bae-fc72-4c93-9dbf-d7d5fc135455"
        //       "email_verified" => true
        //       "name" => "Florian El-Ahdab"
        //       "preferred_username" => "f.el-ahdab"
        //       "given_name" => "Florian"
        //       "family_name" => "El-Ahdab"
        //       "email" => "florian.el-ahdab@adalfantln.marine.defensecdd.gouv.fr"
        //     ]
        //     +attributes: array:4 [▼
        //       "id" => "fae19bae-fc72-4c93-9dbf-d7d5fc135455"
        //       "nickname" => "f.el-ahdab"
        //       "name" => "Florian El-Ahdab"
        //       "email" => "florian.el-ahdab@adalfantln.marine.defensecdd.gouv.fr"
        //     ]
        //     +token: "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJUeHQyc21xcEdKS2hwS3lDZnpYNVFMRVJEd1d1VnpMZ0NBbUVPLU9KMjdvIn0.eyJleHAiOjE3MjkyNTg1OTgsImlhdCI6MTcyOTI1ODI5OCwi
        //    ▶
        //   "
        //     +refreshToken: "eyJhbGciOiJIUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJmZjEwOThhZC1iYjg1LTQ1MzQtOWRlYi0xZDNiOGI4MGMxOTMifQ.eyJleHAiOjE3MjkyNjAwOTgsImlhdCI6MTcyOTI1ODI5OCwianRpIjoiY
        //    ▶
        //   "
        //     +expiresIn: 300
        //     +approvedScopes: array:3 [▼
        //       0 => "openid"
        //       1 => "profile"
        //       2 => "email"
        //     ]
        //     +accessTokenResponseBody: array:9 [▼
        //       "access_token" => "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJUeHQyc21xcEdKS2hwS3lDZnpYNVFMRVJEd1d1VnpMZ0NBbUVPLU9KMjdvIn0.eyJleHAiOjE3MjkyNTg1OTgsImlhdCI6MTcyOTI1ODI5OCwi
        //    ▶
        //   "
        //       "expires_in" => 300
        //       "refresh_expires_in" => 1800
        //       "refresh_token" => "eyJhbGciOiJIUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJmZjEwOThhZC1iYjg1LTQ1MzQtOWRlYi0xZDNiOGI4MGMxOTMifQ.eyJleHAiOjE3MjkyNjAwOTgsImlhdCI6MTcyOTI1ODI5OCwianRpIjoiY
        //    ▶
        //   "
        //       "token_type" => "Bearer"
        //       "id_token" => "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJUeHQyc21xcEdKS2hwS3lDZnpYNVFMRVJEd1d1VnpMZ0NBbUVPLU9KMjdvIn0.eyJleHAiOjE3MjkyNTg1OTgsImlhdCI6MTcyOTI1ODI5OCwi
        //    ▶
        //   "
        //       "not-before-policy" => 0
        //       "session_state" => "c2d897e9-5ffb-4342-a216-d91362b1e82a"
        //       "scope" => "openid profile email"
        //     ]
        //   }

        // si le user n'existe pas, test de la variable APP_VALID_MDC pour savoir si on l'enregistre dans la table MDC 
        if (! config('skeletor.validation_automatique_des_comptes_mindef_connect')){
            // on cree un compte temporaire ds MDC
            $MCuserexist = MindefConnectUser::where('email', $MCuser->email)->get()->first();
            if ($MCuserexist) {
                $MCuserexist->updated_at = date('Y-m-d G:i:s');
                $MCuserexist->msg = true;
            } 
            else {
                $MCuserexist = MindefConnectUser::create(
                    [
                        'sub' => $MCuser->user['sub'],
                        'email' => $MCuser->email,
                        'name' => $MCuser->user['family_name'],
                        'prenom' => $MCuser->user['given_name'],
                        'display_name' => $MCuser->user['name'],
                    ]
                );
            }
            return view('auth.comebacklater', ['MCuserexist' => $MCuserexist]);
        }
        // variable false = on cree directement le user dans user
        else{

            $Newuser=User::create(
                [
                    "password" =>substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10),
                    'email' => $MCuser->email,
                    'nom' => $MCuser->user['family_name'],
                    'prenom' => $MCuser->user['given_name'],
                    'display_name' => $MCuser->user['name']
                ]
            );
            $role= Role::where('name', config('skeletor.groupe_par_defaut_des_nouveaux_comptes'))->first();
            $Newuser->roles()->attach($role->id);
            $Newuser->storeMindefConnectInformations($MCuser->user);
            Auth::login($Newuser);
            return $this->authenticated($request, $Newuser);
        }
    }

    public function newMdcLogin(Request $request, MindefConnectUser $MCuserexist)
    {
        //enregistrer le commentaire
        $MCuserexist->commentaire = $request->comment_mdconnect;
        $MCuserexist->save();

        $response = Http::withoutVerifying()
            ->withHeaders(["X-Auth-AccessKey" => env("TULEAP_TOKEN")])
            ->post(
                env("TULEAP_URL") . "api/artifacts",
                [
                    "tracker" =>  ["id" => env('TULEAP_TRACKER_MINDEFCONNECT')],
                    "values_by_field" => [
                        "affectation" =>  ["value"  => $MCuserexist->main_department_number],
                        "user" => ["value" => $MCuserexist->display_name],
                        "raison" => ["value" => $MCuserexist->commentaire],
                        "instance" => ["value" => env("APP_PREFIX")]
                    ]
                ]
            );

            return redirect()->route(config('skeletor.page_par_defaut'));
            // return view('home.index');
    }

    public function locallogin(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) {
            return redirect()->to(route('login'))
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

    /**
     * Dispay page for send link reset pwd
     * @return view
     */
    public function indexforgotpwd()
    {
        return view('auth.forgotpassword');
    }

    /**
     * send link to the user email
     * @param Request $request
     */
    public function forgotpwd(Request $request)
    {
        $request->validate(['email' => "required|email"]);
        //$user = User::getEmailSingle($request->email);
        $user = Auth::guard()->getProvider()->retrieveByCredentials(['email' => $request->email]);
        if (!empty($user)) {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? view('auth.login')->with(['success' => 'email envoyé'])
                : back()->withErrors(['email' => __($status)]);
        } else {
            return back()->withErrors('l\'email n\'est pas dans la base de donnée');
        }
    }

    /**
     * Display page reset password
     * @param string $token
     */
    public function resetpwdpage(string $token, string $email)
    {
        return view('auth.resetpassword', ['token' => $token, 'email' => $email]);
    }

    /**
     * Update the password with new pwd
     * @param Request $request
     */
    public function updatepwd(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->setPasswordAttribute($password);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? view('auth.login')->with(['success' => 'mot de passe modifié'])
            : redirect(route('password.reset', ['token' => $request->input('token'), 'email' => $request->input('email')]))
            ->withErrors(['email' => [__($status)]]);
    }
}
