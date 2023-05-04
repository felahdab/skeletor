<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class LiensTest extends DuskTestCase
{

    public function test_liens_page_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('liens.index'))
                  ->assertSee('Liens');
        });
        
        $user->forceDelete();
    }
}
