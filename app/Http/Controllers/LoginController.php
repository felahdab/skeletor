<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Events\UnUtilisateurLocalAEteCreeEvent;
use App\Models\MindefConnectUser;
use App\Models\User;
use App\Service\RandomPasswordGeneratorService;
use App\Service\AnnudefAjaxRequestService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
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
        [$logo, $sso_name] = match (config('skeletor.reseau_de_deploiement')) {
            'intradef' => [asset('assets/images/MDC_intradef.png'), 'Mindef Connect'],
            'sic21' => [asset('assets/images/Keycloak.png'), 'POLARIS Online']
        };

        return view('auth.login', ['logo' => $logo, 'sso_name' => $sso_name]);
    }

    /**
     * Handle account login request.
     *
     * @param LoginRequest $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $MCuser = null;

        try {
            $driver = Socialite::driver('keycloak');
            $driver->setHttpClient(new Client(['verify' => false]));

            $MCuser = $driver->stateless()->user();
        } catch (ClientException $e) {
            logger()->error('Error while trying to get user from SSO', ['exception' => $e->getMessage()]);

            return redirect()->route('login')->withErrors(['error' => 'Erreur de connexion au serveur SSO. Veuillez réessayer plus tard ou utiliser votre login local.']);
        }

        // /ddd($MCuser);

        $user = User::where('sub', $MCuser->user['sub'])->first();
        if (null != $user) {
            $user->storeMindefConnectInformations($MCuser->user);
            Auth::login($user);
            logger()->info('Logged user based on sub attribute.', ['user' => $user]);

            // Let's update the email information from the SSO server.
            $user->email = $MCuser->user['email'];
            $user->save();

            return $this->authenticated($request, $user);
        }

        $user = User::where('email', $MCuser->email)->first();
        if (null != $user) {
            $user->storeMindefConnectInformations($MCuser->user);
            Auth::login($user);

            // Let's save the sub of the user so that it is used next time the user logs in.
            if (null == $user->sub) {
                $user->sub = $MCuser->user['sub'];
                $user->save();
            }

            logger()->info('Logged user based on sub attribute.', ['user' => $user]);

            return $this->authenticated($request, $user);
        }

        // si le user n'existe pas, test de la configuration de l'instance pour savoir si on l'enregistre dans la table MDC ou si on créé le compte immédiatement
        if (!config('skeletor.validation_automatique_des_comptes_mindef_connect')) {
            // on cree un compte temporaire ds MDC
            $MCuserexist = MindefConnectUser::where('email', $MCuser->email)->first();
            if ($MCuserexist) {
                $MCuserexist->updated_at = date('Y-m-d G:i:s');
                $MCuserexist->msg = true;
            } else {
                $mapping = match (config('skeletor.reseau_de_deploiement')) {
                    'intradef' => [
                        'sub' => $MCuser->user['sub'],
                        'email' => $MCuser->email,
                        'nom' => $MCuser->user['usual_name'],
                        'prenom' => $MCuser->user['usual_forename'],
                        'main_department_number' => $MCuser->user['main_department_number'],
                        'personal_title' => $MCuser->user['personal_title'],
                        'rank' => $MCuser->user['rank'],
                        'short_rank' => $MCuser->user['short_rank'],
                        'display_name' => $MCuser->user['display_name'],
                    ],
                    'sic21' => [
                        'sub' => $MCuser->user['sub'],
                        'email' => $MCuser->email,
                        'nom' => $MCuser->user['family_name'],
                        'prenom' => $MCuser->user['given_name'],
                        'display_name' => $MCuser->user['name'],
                    ]
                };
                $MCuserexist = MindefConnectUser::create($mapping);
            }

            return view('auth.comebacklater', ['MCuserexist' => $MCuserexist]);
        }
        // variable false = on cree directement le user dans user

        $mapping = match (config('skeletor.reseau_de_deploiement')) {
            'intradef' => [
                'sub' => $MCuser->user['sub'],
                'password' => RandomPasswordGeneratorService::generateRandomString(),
                'email' => $MCuser->email,
                'nom' => $MCuser->user['usual_name'],
                'prenom' => $MCuser->user['usual_forename'],
                'display_name' => $MCuser->user['display_name'],
                'date_embarq' => date('Y-m-d'),
            ],
            'sic21' => [
                'sub' => $MCuser->user['sub'],
                'password' => RandomPasswordGeneratorService::generateRandomString(),
                'email' => $MCuser->email,
                'nom' => $MCuser->user['family_name'],
                'prenom' => $MCuser->user['given_name'],
                'display_name' => $MCuser->user['name'],
            ]
        };

        $Newuser = User::create($mapping);
        
        if ("intradef" === config('skeletor.reseau_de_deploiement')){
            $nid = AnnudefAjaxRequestService::searchUserNidByEmail($MCuser->email);

            $description = [
                'nom' => $MCuser->user['usual_name'],
                'prenom' => $MCuser->user['usual_forename'],
                'email' => $MCuser->email,
                'unite' => $MCuser->user['main_department_number'],
                'nid' => $nid,
                'gradelong' => $MCuser->user['rank'],
            ];

            UnUtilisateurLocalAEteCreeEvent::dispatch($description);
        }

        $role = Role::where('name', config('skeletor.groupe_par_defaut_des_nouveaux_comptes'))->first();
        if ($role) {
            $Newuser->roles()->attach($role->id);
        }

        $Newuser->storeMindefConnectInformations($MCuser->user);

        Auth::login($Newuser);

        return $this->authenticated($request, $Newuser);
    }

    public function newMdcLogin(Request $request, MindefConnectUser $MCuserexist)
    {
        // enregistrer le commentaire
        $MCuserexist->commentaire = $request->comment_mdconnect;
        $MCuserexist->save();

        $TULEAP_TOKEN = config('skeletor.services.tuleap.token');
        $TULEAP_URL = config('skeletor.services.tuleap.url');
        $TULEAP_TRACKER_MINDEFCONNECT = config('skeletor.services.tuleap.tracker_mindef_connect');

        if ('intradef' == config('skeletor.reseau_de_deploiement')) {
            $response = Http::withoutVerifying()
                ->withHeaders(['X-Auth-AccessKey' => $TULEAP_TOKEN])
                ->post(
                    $TULEAP_URL.'api/artifacts',
                    [
                        'tracker' => ['id' => $TULEAP_TRACKER_MINDEFCONNECT],
                        'values_by_field' => [
                            'affectation' => ['value' => $MCuserexist->main_department_number],
                            'user' => ['value' => $MCuserexist->display_name],
                            'raison' => ['value' => $MCuserexist->commentaire],
                            'instance' => ['value' => config('skeletor.prefixe_instance')],
                        ],
                    ]
                )
            ;
        }

        return redirect()->route(config('skeletor.page_par_defaut'));
        // return view('home.index');
    }

    public function locallogin(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) {
            return redirect()->to(route('login'))
                ->withErrors(trans('auth.failed'))
            ;
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        logger()->info("Logged user based on local credentials.", ["user" => $user]);
        return $this->authenticated($request, $user);
    }

    /**
     * Dispay page for send link reset pwd.
     *
     * @return view
     */
    public function indexforgotpwd()
    {
        return view('auth.forgotpassword');
    }

    /**
     * send link to the user email.
     */
    public function forgotpwd(Request $request)
    {
        [$logo, $sso_name] = match (config('skeletor.reseau_de_deploiement')) {
            'intradef' => [asset('assets/images/MDC_intradef.png'), 'Mindef Connect'],
            'sic21' => [asset('assets/images/Keycloak.png'), 'POLARIS Online']
        };

        $request->validate(['email' => 'required|email']);
        // $user = User::getEmailSingle($request->email);
        $user = Auth::guard()->getProvider()->retrieveByCredentials(['email' => $request->email]);
        if (!empty($user)) {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return Password::RESET_LINK_SENT === $status
                ? view('auth.login', ['logo' => $logo, 'sso_name' => $sso_name])->with(['success' => 'email envoyé'])
                : back()->withErrors(['email' => __($status)]);
        }

        return back()->withErrors('l\'email n\'est pas dans la base de donnée');
    }

    /**
     * Display page reset password.
     */
    public function resetpwdpage(string $token, string $email)
    {
        return view('auth.resetpassword', ['token' => $token, 'email' => $email]);
    }

    /**
     * Update the password with new pwd.
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

        [$logo, $sso_name] = match (config('skeletor.reseau_de_deploiement')) {
            'intradef' => [asset('assets/images/MDC_intradef.png'), 'Mindef Connect'],
            'sic21' => [asset('assets/images/Keycloak.png'), 'POLARIS Online']
        };

        return Password::PASSWORD_RESET === $status
            ? view('auth.login', ['logo' => $logo, 'sso_name' => $sso_name])->with(['success' => 'mot de passe modifié'])
            : redirect(route('password.reset', ['token' => $request->input('token'), 'email' => $request->input('email')]))
                ->withErrors(['email' => [__($status)]])
        ;
    }

    /**
     * Handle response after user authenticated.
     *
     * @param Auth $user
     *
     * @return Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('home.index');
    }
}
