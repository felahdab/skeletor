<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class AnnudefTest extends DuskTestCase
{

    public function test_annudef_page_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('annudef.index'))
                  ->assertSee('Annudef');
        });
        
        $user->forceDelete();
    }

    public function test_annudef_search_by_name_doesnt_crash()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('annudef.index'))
                  ->type('@input-nom', 'EL-AHDAB')
                  ->pause(1000)
                  ->assertSee('CV');
        });
        
        $user->forceDelete();
    }
}
