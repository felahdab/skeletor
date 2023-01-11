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
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser) use ($user){
            $browser->loginAs($user)
                  ->visit(route('home.index'))
                  ->assertSee('Accueil');
        });
        
        $user->forceDelete();
    }

    public function test_users_table_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->loginAs($user)
                  ->visit(route('home.index'))
                  ->assertSee('Accueil')
                  ->click("@administration-button")
                  ->assertSee('Demandes Mindef Connect');
        });
        
        $user->forceDelete();
    }
}
