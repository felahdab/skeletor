<?php

namespace Modules\Transformation\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;
use App\Models\Fonction;

class LivretMultipleTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_livret_multiple_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $fonction=Fonction::first();

        $user->fonctions()->attach($fonction);

        $this->browse(function ($browser)  use ($user, $fonction){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('fonctions.choixmarins', ["fonction" => $fonction]))
                  ->assertSee('Validation collective');
        });
        
        $user->forceDelete();
    }

    public function test_livret_multiple_shows_assigned_user()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $fonction=Fonction::first();

        $user->fonctions()->attach($fonction);
        
        $this->browse(function ($browser)  use ($user, $fonction){
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('fonctions.choixmarins', ["fonction" => $fonction]))
                ->assertSee('Validation collective')
                ->click("@livret-multiple-enregistrer")
                ->assertSee($user->display_name);

        });
        
        $user->forceDelete();
    }
}
