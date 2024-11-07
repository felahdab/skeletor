<?php

use function Pest\Livewire\livewire;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard;
use App\Filament\Resources\UserResource;

use App\Models\User;
use function Pest\Laravel\{actingAs};

use Illuminate\Foundation\Testing\RefreshDatabase;
 
uses(RefreshDatabase::class);

it('has a login page', function () {
    $response = $this->get('/apps/login');

    $response->assertStatus(200);
});

it('displays the admin panel', function() {
    Filament::setCurrentPanel(
        Filament::getPanel('admin'), // Where `app` is the ID of the panel you want to test.
    );

    livewire(Dashboard::class)
        ->assertSee('Tableau de bord');
});

it('displays the users table for admins', function() {
    $admin=User::factory()->create();
    $admin->admin=1;
    $admin->save();

    Filament::setCurrentPanel(
        Filament::getPanel('admin'), // Where `app` is the ID of the panel you want to test.
    );

    actingAs($admin)->get(UserResource::getUrl('index'))->assertSuccessful();
});

it('doesnt display the users table for non admins', function() {
    $user=User::factory()->create();

    Filament::setCurrentPanel(
        Filament::getPanel('admin'), // Where `app` is the ID of the panel you want to test.
    );

    actingAs($user)->get(UserResource::getUrl('index'))->assertForbidden();
});