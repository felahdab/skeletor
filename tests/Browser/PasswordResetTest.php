<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class PasswordResetTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testRequestPasswordResetPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.indexforgotpwd'))
                ->assertSee('Réinitialiser le mot de passe')
            ;
        });
    }

    public function testRequestPasswordResetPageErrorWhenInvalidEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.indexforgotpwd'))
                ->type('@email-input', 'invalid@test.fr')
                ->press('@valid-btn')
                ->assertSee('l\'email n\'est pas dans la base de donnée')
            ;
        });
    }

    public function testRequestPasswordResetPageWhenValidEmailRedirectsToLoginPage()
    {
        $user = User::where('email', 'admin@intradef.gouv.fr')->first();
        Password::deleteToken($user);

        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.indexforgotpwd'))
                ->type('@email-input', 'admin@intradef.gouv.fr')
                ->press('@valid-btn')
                ->assertSee('Mot de passe oublié')
            ;
        });
    }

    public function testRequestPasswordErrorWhenTooManyTries()
    {
        $user = User::where('email', 'admin@intradef.gouv.fr')->first();
        Password::deleteToken($user);

        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.indexforgotpwd'))
                ->type('@email-input', 'admin@intradef.gouv.fr')
                ->press('@valid-btn')
                ->assertSee('Mot de passe oublié')
                ->visit(route('login.indexforgotpwd'))
                ->type('@email-input', 'admin@intradef.gouv.fr')
                ->press('@valid-btn')
                ->assertSee('Veuillez patienter avant de réessayer')
            ;
        });
    }
}
