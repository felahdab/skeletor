<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;

pest()->group('Skeletor');

it('accepte une demande de reinitialisation de mot de passe pour un utilisateur existant', function () {
    Mail::fake();

    $user = User::factory()->create();
    $user->save();

    $response = $this->get(route('login.indexforgotpwd'));
    ob_end_flush();
    $response->assertStatus(200);

    $response = $this->post(route('login.forgotpwd'), ['email' => $user->email]);
    ob_end_flush();
    $response->assertStatus(200);
    // Penser à définir SKELETOR_INTRADEF_MAIL_TLD si ce test échoue.    
});

it('refuse une demande de reinitialisation de mot de passe pour un utilisateur n existant pas', function () {
    Mail::fake();

    $response = $this->get(route('login.indexforgotpwd'));
    ob_end_flush();
    $response->assertStatus(200);

    $response = $this->post(route('login.forgotpwd'), ['email' => 'toto@exmaple.com']);
    $response->assertStatus(302);

});
