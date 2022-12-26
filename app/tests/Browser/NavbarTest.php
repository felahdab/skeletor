<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class NavbarTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
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
