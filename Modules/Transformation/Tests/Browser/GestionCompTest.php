<?php

namespace Modules\Transformation\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

use Modules\Transformation\Entities\Compagnonage;

class GestionCompTest extends DuskTestCase
{
    public function test_comps_s_affichent(): void
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $this->browse(function ($browser)  use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::compagnonages.index'))
                ->assertSee('Gérer les compagnonnages');
        });

        $user->forceDelete();
    }

    public function test_comp_consultation(): void
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $comp=Compagnonage::first();

        $this->browse(function ($browser)  use ($user, $comp) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::compagnonages.show', $comp))
                ->assertInputValue("comp[comp_libcourt]", $comp->comp_libcourt);
        });

        $user->forceDelete();
    }

    public function test_comp_edition(): void
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $comp=Compagnonage::first();

        $this->browse(function ($browser)  use ($user, $comp) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::compagnonages.edit', $comp))
                ->assertInputValue("comp[comp_libcourt]", $comp->comp_libcourt);
        });

        $user->forceDelete();
    }

    public function test_comp_edition_ajouter_tache(): void
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $comp=Compagnonage::first();

        $this->browse(function ($browser)  use ($user, $comp) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::compagnonages.edit', $comp))
                ->assertInputValue("comp[comp_libcourt]", $comp->comp_libcourt)
                ->resize(1450, 3000)
                // ->pause(3000)
                ->click('@ajouter_tache')
                ->assertSee('pour le compagnonnage')
                ->click('@select-tache')
                ->assertInputValue("comp[comp_libcourt]", $comp->comp_libcourt);
        });

        $user->forceDelete();
    }

    public function test_comp_edition_retirer_tache(): void
    {
        $user = User::factory()->create();
        $user->admin = true;
        $user->save();

        $comp=Compagnonage::first();

        $this->browse(function ($browser)  use ($user, $comp) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::compagnonages.edit', $comp))
                ->assertInputValue("comp[comp_libcourt]", $comp->comp_libcourt)
                ->resize(1450, 3000)
                // ->pause(3000)
                ->click('@retirer-tache')
                ->assertInputValue("comp[comp_libcourt]", $comp->comp_libcourt);
        });

        $user->forceDelete();
    }

    
}
