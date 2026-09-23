<?php

use App\Filament\Resources\PoseidoninstanceResource;
use App\Filament\Resources\PoseidoninstanceResource\Pages\ListPoseidoninstances;
use App\Filament\Resources\PoseidoninstanceResource\Pages\ViewPoseidoninstance;
use App\Models\Poseidoninstance;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('displays active state on the Poseidoninstance list', function () {
    $admin = User::factory()->create(['admin' => true]);
    $active = Poseidoninstance::factory()->create([
        'last_seen' => Carbon::now()->subHours(1),
    ]);
    $inactive = Poseidoninstance::factory()->create([
        'last_seen' => Carbon::now()->subHours(49),
    ]);

    Livewire::actingAs($admin)
        ->test(ListPoseidoninstances::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$active, $inactive])
        ->assertTableColumnStateSet('active', true, $active)
        ->assertTableColumnStateSet('active', false, $inactive);
});

it('displays active state on the Poseidoninstance view page', function () {
    $admin = User::factory()->create(['admin' => true]);
    $instance = Poseidoninstance::factory()->create([
        'last_seen' => Carbon::now()->subHours(1),
    ]);

    Livewire::actingAs($admin)
        ->test(ViewPoseidoninstance::class, ['record' => $instance->id])
        ->assertSuccessful()
        ->assertSchemaComponentStateSet('active', true, 'infolist');
});

it('does not break when node details contain invalid json', function () {
    $resource = new ReflectionClass(PoseidoninstanceResource::class);
    $formatter = $resource->getMethod('formatJsonState');
    $formatter->setAccessible(true);

    expect($formatter->invoke(null, '{invalid json'))
        ->toBe('{invalid json');
});
