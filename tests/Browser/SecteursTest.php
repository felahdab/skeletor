<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Models\User;

class SecteursTest extends DuskTestCase
{

    public function test_secteurs_list_displays()
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->browse(function ($browser)  use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('secteurs.index'))
                ->assertSee('secteurs');
        });

        $user->forceDelete();
    }

    
}
