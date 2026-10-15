<?php

use App\Filament\Pages\UserPreferences;
use App\Filament\PanelRegistry\ModuleDefinedUserPreferencesRegistry;
use App\Filament\PanelRegistry\UserPreferenceSection;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('displays module-defined user preferences with their current values', function () {
    $user = User::factory()->create([
        'data' => [
            'settings' => [
                'example_module' => [
                    'signature' => 'Signature existante',
                ],
            ],
        ],
    ]);

    app(ModuleDefinedUserPreferencesRegistry::class)->registerUserPreferenceSections(
        UserPreferenceSection::make('example_module')
            ->label('Préférences du module exemple')
            ->description('Options personnelles du module.')
            ->schema([
                TextInput::make('signature')
                    ->label('Signature personnalisée'),
            ]),
    );

    Livewire::actingAs($user)
        ->test(UserPreferences::class)
        ->assertSee('Préférences du module exemple')
        ->assertSee('Options personnelles du module.')
        ->assertSee('Signature personnalisée')
        ->assertFormSet([
            'module_preferences.example_module.signature' => 'Signature existante',
        ]);
});

it('saves module-defined preferences without removing other user data', function () {
    $user = User::factory()->create([
        'data' => [
            'profile_metadata' => 'à conserver',
            'settings' => [
                'unregistered_module' => [
                    'value' => 'inchangée',
                ],
                'example_module' => [
                    'signature' => 'Ancienne signature',
                    'setting_no_longer_in_form' => 'à conserver',
                ],
            ],
        ],
    ]);

    app(ModuleDefinedUserPreferencesRegistry::class)->registerUserPreferenceSections(
        UserPreferenceSection::make('example_module')
            ->label('Préférences du module exemple')
            ->schema([
                TextInput::make('signature')->required(),
                Toggle::make('notifications_enabled'),
            ]),
    );

    Livewire::actingAs($user)
        ->test(UserPreferences::class)
        ->fillForm([
            'module_preferences.skeletor.prefered_page' => null,
            'module_preferences.example_module.signature' => 'Nouvelle signature',
            'module_preferences.example_module.notifications_enabled' => true,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $user->refresh();

    expect($user->data)
        ->profile_metadata->toBe('à conserver')
        ->settings->unregistered_module->value->toBe('inchangée')
        ->settings->example_module->signature->toBe('Nouvelle signature')
        ->settings->example_module->notifications_enabled->toBeTrue()
        ->settings->example_module->setting_no_longer_in_form->toBe('à conserver');
});

it('does not display or overwrite a module preference section hidden from the user', function () {
    $user = User::factory()->create([
        'data' => [
            'settings' => [
                'example_module' => [
                    'private_value' => 'Valeur existante',
                ],
            ],
        ],
    ]);

    app(ModuleDefinedUserPreferencesRegistry::class)->registerUserPreferenceSections(
        UserPreferenceSection::make('example_module')
            ->label('Préférences privées')
            ->visible(fn (User $candidate): bool => $candidate->isNot($user))
            ->schema([
                TextInput::make('private_value'),
            ]),
    );

    Livewire::actingAs($user)
        ->test(UserPreferences::class)
        ->assertDontSee('Préférences privées')
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->refresh()->data['settings']['example_module']['private_value'])
        ->toBe('Valeur existante');
});

it('rejects invalid and duplicate module preference section keys', function () {
    expect(fn () => UserPreferenceSection::make('Invalid.key'))
        ->toThrow(InvalidArgumentException::class);

    $registry = app(ModuleDefinedUserPreferencesRegistry::class);
    $registry->registerUserPreferenceSections(UserPreferenceSection::make('example_module'));

    expect(fn () => $registry->registerUserPreferenceSections(UserPreferenceSection::make('example_module')))
        ->toThrow(InvalidArgumentException::class);
});
