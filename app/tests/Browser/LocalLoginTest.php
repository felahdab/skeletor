<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class LocalLoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_local_login_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('login.show'))
                    ->assertSee('Login');
        });
    }

    public function test_local_login_as_admin()
    {
        $this->artisan('db:seed');
        $user=User::find(1);
        
        $this->browse(function (Browser $browser) use($user) {
            $browser->visit(route('login.show'))
                    ->assertSee('Login')
                    ->type('email', $user->email)
                    ->type('password', 'admin123')
                    ->press('Login')
                    ->assertPathIs('/florian/statistiques/pour2ps');
        });
    }
}
