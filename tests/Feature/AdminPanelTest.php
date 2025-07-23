<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard;

use function Pest\Laravel\{actingAs};
use function Pest\Livewire\livewire;
use Livewire\Livewire;

use App\Models\User;
use App\Filament\Resources\UserResource;
use App\Filament\Pages\UserPreferences;
 
uses(RefreshDatabase::class);

beforeEach(function () {
    Filament::setCurrentPanel(
        Filament::getPanel('admin'), 
    );
});

it('has a login page', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
});

it('displays the admin panel', function() {
    livewire(Dashboard::class)
        ->assertSee('Tableau de bord');
});

it('displays the users table for admins', function() {
    $admin=User::factory()->create();
    $admin->admin=1;
    $admin->save();

    actingAs($admin)->get(UserResource::getUrl('index'))->assertSuccessful();
});

it('doesnt display the users table for non admins', function() {
    $user=User::factory()->create();

    actingAs($user)->get(UserResource::getUrl('index'))->assertForbidden();
});

it('displays the profile page for logged in users', function() {
    $user=User::factory()->create();

    Livewire::actingAs($user)
        ->test(UserPreferences::class)
        ->assertSee('Mes préférences');
});

it('saves the prefered page of the user', function() {
    $user=User::factory()->create();
    $prefered_page_dummy_data = "prefered_page_dummy_data";
    $this->assertTrue(Arr::get($user->data, "settings.prefered_page") == null);

    Livewire::actingAs($user)
        ->test(UserPreferences::class)
        ->assertSee('Mes préférences')
        ->fillForm([
            'prefered_page' => $prefered_page_dummy_data,
        ])
        ->call('save');

    $this->assertTrue(Arr::get($user->data, "settings.prefered_page") == $prefered_page_dummy_data);
});