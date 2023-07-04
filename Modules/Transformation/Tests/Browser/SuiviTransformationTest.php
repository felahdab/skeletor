<?php

namespace Modules\Transformation\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class SuiviTransformationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_suivi_par_fonction_saffiche(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $this->browse(function ($browser)  use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::transformation.indexparfonction'))
                ->assertSee('Liste des fonctions pour validation collective');
        });

        $user->forceDelete();
    }

    public function test_suivi_par_stage_saffiche(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $this->browse(function ($browser)  use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::transformation.indexparstage'))
                ->assertSee('Liste des stages pour validation collective');
        });

        $user->forceDelete();
    }

    public function test_suivi_par_compagnonage_saffiche(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $this->browse(function ($browser)  use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::transformation.indexparcomp'))
                ->assertSee('Transformation par compagnonnage');
        });

        $user->forceDelete();
    }
}
