<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class AnnudefTest extends DuskTestCase
{
    public function testAnnudefPageDisplays()
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->browse(function ($browser) use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('annudef.index'))
                ->assertSee('Annudef')
            ;
        });

        $user->forceDelete();
    }

    public function testAnnudefSearchByNameDoesntCrash()
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->browse(function ($browser) use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('annudef.index'))
                ->type('@input-nom', 'EL-AHDAB')
                ->pause(1000)
                ->assertSee('CV')
            ;
        });

        $user->forceDelete();
    }
}
