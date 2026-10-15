<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renvoie un tableau vide quand aucune preference n est enregistree pour la section', function () {
    $user = User::factory()->make(['data' => null]);

    expect($user->getPreferences('example_module'))->toBe([]);
    expect($user->getPreference('example_module', 'signature'))->toBeNull();
    expect($user->getPreference('example_module', 'signature', 'defaut'))->toBe('defaut');
});

it('lit les preferences enregistrees d une section, y compris en notation pointee', function () {
    $user = User::factory()->make([
        'data' => [
            'settings' => [
                'example_module' => [
                    'signature' => 'Signature existante',
                    'affichage' => ['lignes_par_page' => 25],
                ],
            ],
        ],
    ]);

    expect($user->getPreferences('example_module'))->toBe([
        'signature' => 'Signature existante',
        'affichage' => ['lignes_par_page' => 25],
    ]);
    expect($user->getPreference('example_module', 'signature'))->toBe('Signature existante');
    expect($user->getPreference('example_module', 'affichage.lignes_par_page'))->toBe(25);
});

it('isole les preferences par section', function () {
    $user = User::factory()->make([
        'data' => [
            'settings' => [
                'module_a' => ['valeur' => 'a'],
                'module_b' => ['valeur' => 'b'],
            ],
        ],
    ]);

    expect($user->getPreference('module_a', 'valeur'))->toBe('a');
    expect($user->getPreference('module_b', 'valeur'))->toBe('b');
    expect($user->getPreferences('module_inconnu'))->toBe([]);
});

it('enregistre une preference sans ecraser les autres donnees de l utilisateur', function () {
    $user = User::factory()->make([
        'data' => [
            'profile_metadata' => 'à conserver',
            'settings' => [
                'skeletor' => ['prefered_page' => 'dummy_page_route_name'],
                'autre_module' => ['valeur' => 'inchangée'],
                'example_module' => ['signature' => 'Ancienne signature'],
            ],
        ],
    ]);

    $user->setPreference('example_module', 'signature', 'Nouvelle signature');

    expect($user->data)
        ->profile_metadata->toBe('à conserver')
        ->settings->skeletor->prefered_page->toBe('dummy_page_route_name')
        ->settings->autre_module->valeur->toBe('inchangée')
        ->settings->example_module->signature->toBe('Nouvelle signature');
});

it('accepte la notation pointee pour enregistrer une preference imbriquee', function () {
    $user = User::factory()->make(['data' => null]);

    $user->setPreference('example_module', 'affichage.lignes_par_page', 50);

    expect($user->getPreference('example_module', 'affichage.lignes_par_page'))->toBe(50);
    expect($user->getPreferences('example_module'))->toBe([
        'affichage' => ['lignes_par_page' => 50],
    ]);
});

it('fusionne les preferences fournies avec celles deja enregistrees', function () {
    $user = User::factory()->make([
        'data' => [
            'settings' => [
                'example_module' => [
                    'signature' => 'Ancienne signature',
                    'notifications_enabled' => true,
                ],
            ],
        ],
    ]);

    $user->setPreferences('example_module', ['signature' => 'Nouvelle signature']);

    expect($user->getPreferences('example_module'))->toBe([
        'signature' => 'Nouvelle signature',
        'notifications_enabled' => true,
    ]);
});

it('permet de chainer les appels et ne persiste pas tant que save n est pas appele', function () {
    $user = User::factory()->create(['data' => null]);

    $user->setPreference('example_module', 'signature', 'Nouvelle signature')
        ->setPreference('example_module', 'notifications_enabled', false);

    expect($user->fresh()->getPreferences('example_module'))->toBe([]);

    $user->save();

    expect($user->fresh()->getPreferences('example_module'))->toBe([
        'signature' => 'Nouvelle signature',
        'notifications_enabled' => false,
    ]);
});

it('refuse de lire des preferences de section qui ne sont pas un tableau', function () {
    $user = User::factory()->make([
        'data' => [
            'settings' => [
                'example_module' => 'valeur invalide',
            ],
        ],
    ]);

    expect(fn () => $user->getPreferences('example_module'))
        ->toThrow(UnexpectedValueException::class);
});
