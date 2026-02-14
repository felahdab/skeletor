<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard;

use function Pest\Laravel\{actingAs};
use function Pest\Livewire\livewire;
use Livewire\Livewire;

use App\Models\User;
use App\Models\AnnuaireUser;
use App\Models\Permission;

use App\DataObjects\NewUserDescriptionData;

use App\Filament\Resources\UserResource;
use App\Filament\Pages\UserPreferences;

use App\Filament\PanelRegistry\PreferedPageItem;
use App\Filament\PanelRegistry\ModuleDefinedPreferedPagesRegistry;
 
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

it('sauvegarde la page preferee de l utilisateur', function() {
    $user=User::factory()->create();

    //logger()->info(User::all());

    app(ModuleDefinedPreferedPagesRegistry::class)->registerPreferedPagesItems(
            [
            PreferedPageItem::make()
                ->name('Dummy page')
                ->routeName(fn() => 'dummy_page_route_name'),
            ]
        );

    //logger()->info(app(ModuleDefinedPreferedPagesRegistry::class)->getPreferedPagesItemsForSelect());

    $this->assertTrue(Arr::get($user->data, "settings.prefered_page") == null);

    Livewire::actingAs($user)
        ->test(UserPreferences::class)
        ->assertSee('Mes préférences')
        ->fillForm([
            'prefered_page' => 'dummy_page_route_name',
        ])
        ->assertSee('Dummy page')
        ->call('save')
        ->assertStatus(200);
    $user->refresh();
    //logger()->info($user->data);

    $this->assertTrue(Arr::get($user->data, "settings.prefered_page") == 'dummy_page_route_name');
});

it('affiche la liste des utilisateurs si l utilisateur a la permission users.index', function() {
    $user=User::factory()->create();
    $permission = Permission::firstOrCreate(["name" => "users.index", "guard_name" => "web"]);

    $user->givePermissionTo($permission);
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Resources\UserResource\Pages\ListUsers::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$user]);

});

it('affiche la page d édition d un utilisateur si l utilisateur a la permission users.index et users.edit', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "users.update", "guard_name" => "web"]);
    $permission2 = Permission::firstOrCreate(["name" => "users.index", "guard_name" => "web"]);

    $user->givePermissionTo($permission1);
    $user->givePermissionTo($permission2);
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Resources\UserResource\Pages\EditUser::class, ["record" => $user->id])
        ->assertSuccessful();

});

it('n affiche pas l action permettant de changer le mot de passe si l utilisateur a seulement les permissions users.index et users.edit', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "users.update", "guard_name" => "web"]);
    $permission2 = Permission::firstOrCreate(["name" => "users.index", "guard_name" => "web"]);

    $user->givePermissionTo($permission1);
    $user->givePermissionTo($permission2);
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Resources\UserResource\Pages\EditUser::class, ["record" => $user->id])
        ->assertSuccessful()
        ->assertActionHidden('change-password');

});

it('affiche bien l action permettant de changer le mot de passe si l utilisateur a les permissions users.index et users.edit et skeletor.changer_le_mot_de_passe_des_utilisateurs', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "users.update", "guard_name" => "web"]);
    $permission2 = Permission::firstOrCreate(["name" => "users.index", "guard_name" => "web"]);
    $permission3 = Permission::firstOrCreate(["name" => "skeletor.changer_le_mot_de_passe_des_utilisateurs", "guard_name" => "web"]);
    
    $user->givePermissionTo($permission1);
    $user->givePermissionTo($permission2);
    $user->givePermissionTo($permission3);
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Resources\UserResource\Pages\EditUser::class, ["record" => $user->id])
        ->assertSuccessful()
        ->assertActionVisible('change-password');

});

it('n affiche pas l action permettant de changer le mot de passe si l utilisateur a les permissions users.index et users.edit et skeletor.changer_le_mot_de_passe_des_utilisateurs quand l utilisateur est admin', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "users.update", "guard_name" => "web"]);
    $permission2 = Permission::firstOrCreate(["name" => "users.index", "guard_name" => "web"]);
    $permission3 = Permission::firstOrCreate(["name" => "skeletor.changer_le_mot_de_passe_des_utilisateurs", "guard_name" => "web"]);
    
    $user->givePermissionTo($permission1);
    $user->givePermissionTo($permission2);
    $user->givePermissionTo($permission3);

    $user2=User::factory()->create();
    $user2->admin=1;
    $user2->save();
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Resources\UserResource\Pages\EditUser::class, ["record" => $user2->id])
        ->assertSuccessful()
        ->assertActionHidden('change-password');

});

it('n affiche pas l action permettant de changer le mot de passe si l utilisateur a les permissions users.index et users.edit et skeletor.changer_le_mot_de_passe_des_utilisateurs quand l utilisateur est admin sauf si l utilisateur connecte est aussi admin', function() {
    $user=User::factory()->create();
    $user->admin=1;
    $user->save();

    $user2=User::factory()->create();
    $user2->admin=1;
    $user2->save();
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Resources\UserResource\Pages\EditUser::class, ["record" => $user2->id])
        ->assertSuccessful()
        ->assertActionVisible('change-password');

});

it('affiche bien les groupes d un utilisateur sous sa fiche quand l utilisateur a roles.index', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "users.update", "guard_name" => "web"]);
    $permission2 = Permission::firstOrCreate(["name" => "users.index", "guard_name" => "web"]);
    $permission3 = Permission::firstOrCreate(["name" => "roles.index", "guard_name" => "web"]);
    
    $user->givePermissionTo($permission1);
    $user->givePermissionTo($permission2);
    $user->givePermissionTo($permission3);

    Livewire::actingAs($user)
        ->test(UserResource\RelationManagers\RolesRelationManager::class,
        [
            'ownerRecord' => $user,
            'pageClass' => UserResource\Pages\EditUser::class,
        ])
        ->assertSuccessful();
});

it('affiche bien les permissions d un utilisateur sous sa fiche quand l utilisateur a permissions.index', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "users.update", "guard_name" => "web"]);
    $permission2 = Permission::firstOrCreate(["name" => "users.index", "guard_name" => "web"]);
    $permission3 = Permission::firstOrCreate(["name" => "permissions.index", "guard_name" => "web"]);
    
    $user->givePermissionTo($permission1);
    $user->givePermissionTo($permission2);
    $user->givePermissionTo($permission3);

    Livewire::actingAs($user)
        ->test(UserResource\RelationManagers\PermissionsRelationManager::class,
        [
            'ownerRecord' => $user,
            'pageClass' => UserResource\Pages\EditUser::class,
        ])
        ->assertSuccessful();
});

it('affiche la recherche Annudef si l utilisateur a skeletor.recherche-annuaire', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "skeletor.recherche-annuaire", "guard_name" => "web"]);
    
    $user->givePermissionTo($permission1);
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Pages\RechercheAnnuairePage::class)
        ->assertSuccessful()
        ->assertActionVisible('submitAction');

});

it('affiche le résultat de la recherche Annudef si l utilisateur a skeletor.recherche-annuaire', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "skeletor.recherche-annuaire", "guard_name" => "web"]);

    $user->givePermissionTo($permission1);

    AnnuaireUser::setUsers([
        NewUserDescriptionData::make("nom", "prenomusuel", "email", 'unites', "nid", "gradelong")->toArray()
    ]);
    $resultat = AnnuaireUser::first();
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Pages\RechercheAnnuairePage::class)
        ->assertSuccessful()
        ->assertActionVisible('submitAction')
        ->assertCanSeeTableRecords([$resultat])
        ->assertTableActionHidden('create-local-user', $resultat);

});

it('affiche le résultat de la recherche Annudef et le bouton de creation d un compte local si l utilisateur a skeletor.recherche-annuaire et users.create', function() {
    $user=User::factory()->create();
    $permission1 = Permission::firstOrCreate(["name" => "skeletor.recherche-annuaire", "guard_name" => "web"]);
    $permission2 = Permission::firstOrCreate(["name" => "users.store", "guard_name" => "web"]);

    $user->givePermissionTo($permission1);
    $user->givePermissionTo($permission2);

    AnnuaireUser::setUsers([
        NewUserDescriptionData::make("nom", "prenomusuel", "email", 'unites', "nid", "gradelong")->toArray()
    ]);
    $resultat = AnnuaireUser::first();
    
    Livewire::actingAs($user)
        ->test(\App\Filament\Pages\RechercheAnnuairePage::class)
        ->assertSuccessful()
        ->assertActionVisible('submitAction')
        ->assertCanSeeTableRecords([$resultat])
        ->assertTableActionVisible('create-local-user', $resultat);

});