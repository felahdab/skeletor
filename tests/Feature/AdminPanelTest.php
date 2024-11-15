<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard;

use App\Filament\Resources\UserResource;
use App\Models\User;

use function Pest\Laravel\{actingAs};
use function Pest\Livewire\livewire;

 
uses(RefreshDatabase::class);

beforeEach(function () {
    Filament::setCurrentPanel(
        Filament::getPanel('admin'), 
    );
});

it('has a login page', function () {
    $response = $this->get('/apps/login');

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