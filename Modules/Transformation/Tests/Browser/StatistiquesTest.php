<?php

namespace Modules\Transformation\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class StatistiquesTest extends DuskTestCase
{

    public function test_bilanglobal_page_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('transformation::statistiques.pourem'))
                  ->assertSee('Nb total de marins en transformation');
        });
        
        $user->forceDelete();
    }

    public function test_link_in_bilan_global_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('transformation::statistiques.pourem'))
                  ->assertSee('Nb total de marins en transformation')
                  ->click('@listemarins-fct-lien-0')
                  ->assertSee('Transformation pour la fonction');
        });
        
        $user->forceDelete();
    }

    
}
