<?php

use App\Filament\Pages\UserPreferences;
use App\Filament\PanelRegistry\ModuleDefinedPreferedPagesRegistry;
use App\Filament\PanelRegistry\ModuleDefinedUserPreferencesRegistry;
use App\Filament\PanelRegistry\PreferedPageItem;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('declare la preference de page preferee dans la section skeletor', function () {
    $sections = app(ModuleDefinedUserPreferencesRegistry::class)->getUserPreferenceSections();

    expect($sections)->toHaveKey('skeletor');
    expect($sections['skeletor']->isVisible(User::factory()->make()))->toBeTrue();
});

it('enregistre la page preferee dans la section skeletor depuis la page de preferences', function () {
    $user = User::factory()->create(['data' => null]);

    // Déclarée après le démarrage de l'application: les options doivent être résolues
    // au moment de l'affichage du formulaire.
    app(ModuleDefinedPreferedPagesRegistry::class)->registerPreferedPagesItems(
        PreferedPageItem::make()
            ->name('Page de connexion')
            ->routeName(fn () => 'login'),
    );

    Livewire::actingAs($user)
        ->test(UserPreferences::class)
        ->assertSee('Page préférée')
        ->assertSee('Page de connexion')
        ->fillForm([
            'module_preferences.skeletor.prefered_page' => 'login',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->refresh()->getPreference('skeletor', 'prefered_page'))->toBe('login');
});

it('redirige l utilisateur vers sa page preferee declaree dans la section skeletor', function () {
    $user = User::factory()->create(['data' => null]);
    $user->setPreference('skeletor', 'prefered_page', 'login')->save();

    actingAs($user)
        ->get(route('home.index'))
        ->assertRedirect(route('login'));
});

it('deplace la page preferee historique vers la section skeletor', function () {
    $user = User::factory()->create([
        'data' => [
            'profile_metadata' => 'à conserver',
            'settings' => [
                'prefered_page' => 'dummy_page_route_name',
                'example_module' => ['signature' => 'inchangée'],
            ],
        ],
    ]);

    $userSansPreference = User::factory()->create(['data' => null]);

    $migration = require database_path(
        'migrations/2026_10_15_000000_skeletor_move_prefered_page_to_skeletor_user_preferences.php'
    );

    $migration->up();

    $data = json_decode(DB::table('users')->where('id', $user->id)->value('data'), true);

    expect($data['settings'])->not->toHaveKey('prefered_page');
    expect($data['settings']['skeletor']['prefered_page'])->toBe('dummy_page_route_name');
    expect($data['settings']['example_module']['signature'])->toBe('inchangée');
    expect($data['profile_metadata'])->toBe('à conserver');

    expect($userSansPreference->refresh()->getPreferences('skeletor'))->toBe([]);

    $migration->down();

    $data = json_decode(DB::table('users')->where('id', $user->id)->value('data'), true);

    expect($data['settings']['prefered_page'])->toBe('dummy_page_route_name');
    expect($data['settings'])->not->toHaveKey('skeletor');
});
