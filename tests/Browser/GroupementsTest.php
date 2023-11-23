<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Models\User;

class GroupementsTest extends DuskTestCase
{

    public function test_groupements_list_displays()
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->browse(function ($browser)  use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('groupements.index'))
                ->assertSee('groupements');
        });

        $user->forceDelete();
    }

    
}
