<?php

namespace Modules\Transformation\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;
use Modules\Transformation\Entities\User as TransfoUser;
use Modules\Transformation\Entities\Fonction;

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
        $user->admin = true;
        $user->save();
        
        $fonction=Fonction::first();

        $transfouser = TransfoUser::find($user->id);
        $transfouser->fonctions()->attach($fonction);

        $this->browse(function ($browser)  use ($user, $fonction){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('transformation::fonctions.choixmarins', ["fonction" => $fonction]))
                  ->assertSee('Validation collective');
        });
        
        $user->forceDelete();
    }

    public function test_livret_multiple_shows_assigned_user()
    {
        $user=User::factory()->create();
        $user->admin = true;
        $user->save();
        
        $fonction=Fonction::first();

        $transfouser = TransfoUser::find($user->id);
        $transfouser->fonctions()->attach($fonction);
        
        $this->browse(function ($browser)  use ($user, $fonction){
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::fonctions.choixmarins', ["fonction" => $fonction]))
                ->assertSee('Validation collective')
                ->click("@livret-multiple-enregistrer")
                ->assertSee($user->display_name);

        });
        
        $user->forceDelete();
    }
}
