<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\MindefConnectUser;


pest()->group('Skeletor');
uses(RefreshDatabase::class);

it('prune MindefConnectUser quand un utilisateur existe deja', function () {
    $user = User::factory()->create();
    $mindef_connect = MindefConnectUser::factory()->create(Arr::except($user->toArray(), ["uuid"]));
    $this->assertDatabaseHas('mindef_connect_users', 
    [
        'email' => $user->email
    ]);

    Artisan::call("skeletor:prune-mindef-connect-requests");
    
    $this->assertDatabaseMissing('mindef_connect_users', 
    [
        'email' => $user->email
    ]);
});
