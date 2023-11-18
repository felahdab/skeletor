<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;
use Illuminate\Support\Facades\Password;

class PasswordResetTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_request_password_reset_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.indexforgotpwd'))
                ->assertSee('Réinitialiser le mot de passe');
        });
    }

    public function test_request_password_reset_page_error_when_invalid_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.indexforgotpwd'))
                ->type('@email-input', 'invalid@test.fr')
                ->press('@valid-btn')
                ->assertSee('l\'email n\'est pas dans la base de donnée');
        });
    }

    public function test_request_password_reset_page_when_valid_email_redirects_to_login_page()
    {
        $user = User::where('email', 'admin@intradef.gouv.fr')->first();
        Password::deleteToken($user);

        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.indexforgotpwd'))
                ->type('@email-input', 'admin@intradef.gouv.fr')
                ->press('@valid-btn')
                ->assertSee('Mot de passe oublié');
        });
    }

    public function test_request_password_error_when_too_many_tries()
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
                ->assertSee('Veuillez patienter avant de réessayer');
        });
    }
}
