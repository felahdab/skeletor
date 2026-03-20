<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class LocalLoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testLocalLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login'))
                ->assertSee('Login')
            ;
        });
    }

    public function testLocalLoginAsAdmin()
    {
        $user = User::factory()->create();
        $user->password = 'admin123';
        $user->admin = true;
        $user->save();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->maximize()
                ->visit(route('login'))
                ->assertSee('Login')
                ->type('@login-email', $user->email)
                ->type('@login-password', 'admin123')
                ->press('@login-button')
                ->assertSee($user->name)
            ;
        });

        $user->forceDelete();
    }
}
