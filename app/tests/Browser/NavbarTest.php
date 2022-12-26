<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class NavbarTest extends DuskTestCase
{
    public function test_main_menu_displays()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                  ->visit(route('home.index'))
                  ->assertSee('Accueil');
        });
    }

    public function test_users_table_displays()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                  ->visit(route('home.index'))
                  ->assertSee('Accueil')
                  ->click("@administration-button")
                  ->assertSee('Demandes Mindef Connect');
        });
    }
}
