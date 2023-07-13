<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class LocalLoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_local_login_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                    ->visit(route('login.show'))
                    ->assertSee('Login');
        });
    }

    public function test_local_login_as_admin()
    {
        $user=User::factory()->create();
        $user->password="admin123";
        $user->admin = true;
        $user->save();
        
        $this->browse(function (Browser $browser) use($user) {
            $browser->maximize()
                    ->visit(route('login.show'))
                    ->assertSee('Login')
                    ->type('@login-email', $user->email)
                    ->type('@login-password', 'admin123')
                    ->press('@login-button')
                    ->assertSee($user->name);
        });
        
        $user->forceDelete();
    }
}
