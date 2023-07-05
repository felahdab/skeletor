<?php

namespace Modules\Transformation\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

use Modules\Transformation\Entities\Fonction;

class GestionFonctionTest extends DuskTestCase
{
    public function test_fonctions_s_affichent(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $this->browse(function ($browser)  use ($user) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::fonctions.index'))
                ->assertSee('Gérer les fonctions');
        });

        $user->forceDelete();
    }

    public function test_fonction_consultation(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $fonction=Fonction::first();

        $this->browse(function ($browser)  use ($user, $fonction) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::fonctions.show', $fonction))
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt);
        });

        $user->forceDelete();
    }

    public function test_fonction_edition(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $fonction=Fonction::first();

        $this->browse(function ($browser)  use ($user, $fonction) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::fonctions.edit', $fonction))
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt);
        });

        $user->forceDelete();
    }

    public function test_fonction_edition_ajouter_compagnonnage(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $fonction=Fonction::first();

        $this->browse(function ($browser)  use ($user, $fonction) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::fonctions.edit', $fonction))
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt)
                ->resize(1450, 3000)
                // ->pause(3000)
                ->click('@ajouter_compagnonnage')
                ->assertSee('un compagnonnage pour la fonction')
                ->click('@select-comp')
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt);
        });

        $user->forceDelete();
    }

    public function test_fonction_edition_ajouter_stage(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $fonction=Fonction::first();

        $this->browse(function ($browser)  use ($user, $fonction) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::fonctions.edit', $fonction))
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt)
                ->resize(1450, 3000)
                // ->pause(3000)
                ->click('@ajouter_stage')
                ->assertSee('un stage pour la fonction')
                ->click('@select-stage')
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt);
        });

        $user->forceDelete();
    }

    public function test_fonction_edition_retirer_stage(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $fonction=Fonction::first();

        $this->browse(function ($browser)  use ($user, $fonction) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::fonctions.edit', $fonction))
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt)
                ->resize(1450, 3000)
                // ->pause(3000)
                ->click('@retirer_stage')
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt);
        });

        $user->forceDelete();
    }

    public function test_fonction_edition_retirer_compagnonnage(): void
    {
        $user = User::factory()->create();
        $user->assignRole("admin");

        $fonction=Fonction::first();

        $this->browse(function ($browser)  use ($user, $fonction) {
            $browser->maximize()
                ->loginAs($user)
                ->visit(route('transformation::fonctions.edit', $fonction))
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt)
                ->resize(1450, 3000)
                // ->pause(3000)
                ->click('@retirer-comp')
                ->assertInputValue('fonction[fonction_libcourt]', $fonction->fonction_libcourt);
        });

        $user->forceDelete();
    }

    
}
