<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;


use App\Models\User;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Notifications\ResetPassword;

class LoginControllerTest extends TestCase
{
	use RefreshDatabase;

	public function test_locallogin_page_displays()
	{
		//            print_r(route('login.show'));    
		$response = $this->get(route('login.show'));

		$response->assertSuccessful();
	}

	public function test_login_failure()
	{
		$this->seed();
		$user = User::factory()->create();
		$this->followingRedirects()
			->from(route('login.show'))
			->post(route('login.perform'), [
				'email' => $user->email,
				'password' => 'zboobie'
			])
			->assertViewIs('auth.login')
			->assertSee('Ces identifiants ne correspondent pas à nos enregistrements');

		$this->assertGuest();
	}

	public function test_login_success()
	{
		$this->seed();
		$user = User::factory()->create();
		$this->followingRedirects()
			->from(route('login.show'))
			->post(route('login.perform'), [
				'email' => $user->email,
				'password' => 'password'
			])
			->assertSuccessful();

		$this->assertAuthenticatedAs($user);
	}


	const ROUTE_PASSWORD_RESET_REQUEST = 'login.indexforgotpwd';
	const ROUTE_PASSWORD_RESET_REQUEST_SUBMIT = 'login.forgotpwd';
	const ROUTE_PASSWORD_RESET = 'password.reset';
	const ROUTE_PASSWORD_RESET_SUBMIT = 'login.updatepwd';

	public function testShowPasswordResetRequestPage()
	{
		$this->get(route(self::ROUTE_PASSWORD_RESET_REQUEST))
			->assertSuccessful();
	}

	/**
	 * Test de l'envoie de l'email de reinitialisation du mot de passe.
	 * Test du retour de la vue vers la page login.
	 */
	public function test_reset_notification_send_success_for_valid_email()
	{
		Notification::fake();
		$this->seed();

		$user = User::factory()->create([
			'email' => 'test@intradef.gouv.fr',
		]);

		$this->followingRedirects()
			->from(route(self::ROUTE_PASSWORD_RESET_REQUEST))
			->post(route(self::ROUTE_PASSWORD_RESET_REQUEST_SUBMIT), [
				'email' => $user->email
			])
			->assertSuccessful()
			->assertViewIs('auth.login');

		Notification::assertSentTo($user, ResetPassword::class);
	}

	public function test_reset_notification_send_fails_for_invalid_email()
	{
		Notification::fake();
		$this->seed();

		$this->followingRedirects()
			->from(route(self::ROUTE_PASSWORD_RESET_REQUEST))
			->post(route(self::ROUTE_PASSWORD_RESET_REQUEST_SUBMIT), [
				'email' => 'invalidemail@test.fr'
			])
			->assertSuccessful()
			->assertViewIs('auth.forgotpassword');

		Notification::assertNothingSent();
	}

	/**
	 * Testing showing the reset password page.
	 */
	public function testShowPasswordResetPageSucceedsWithValidUserAndToken()
	{
		$this->seed();
		$user = User::factory()->create([
			'email' => 'test@intradef.gouv.fr',
		]);
		$token = Password::broker()->createToken($user);

		$this->followingRedirects()
			->from(route('home.index'))
			->get(route(self::ROUTE_PASSWORD_RESET, [
				'token' => $token, 'email' => $user->email
			]))
			->assertSuccessful();
	}

	/**
	 * Testing showing the reset password page.
	 */
	public function testShowPasswordResetPageSucceedsAlsoWithInvalidToken()
	{
		$this->seed();
		$user = User::factory()->create([
			'email' => 'test@intradef.gouv.fr',
		]);
		$token = 'invalid_token';

		$this->followingRedirects()
			->from(route('home.index'))
			->get(route(self::ROUTE_PASSWORD_RESET, [
				'token' => $token, 'email' => $user->email
			]))
			->assertSuccessful(); // Normal: on ne devoile pas à l'utilisateur malveillant que son token n'est pas valide.
	}

	public function testShowPasswordResetPageSucceedsAlsoWithInvalidEmail()
	{
		$this->seed();
		$token = 'invalid_token';

		$this->followingRedirects()
			->from(route('home.index'))
			->get(route(self::ROUTE_PASSWORD_RESET, [
				'token' => $token, 'email' => 'invalid@test.fr'
			]))
			->assertSuccessful(); // Normal: on ne devoile pas à l'utilisateur malveillant que son token n'est pas valide.
	}

	public function test_change_pwd_fails_if_invalid_token()
	{
		$this->seed();
		$user = User::factory()->create([
			'email' => 'test@intradef.gouv.fr',
		]);
		$this->assertTrue(Hash::check('password', $user->password));

		$token = 'invalid_reset_token';

		$response = $this->post(route(self::ROUTE_PASSWORD_RESET_SUBMIT), [
			'email' => $user->email,
			'password' => "password",
			'password_confirmation' => "password",
			'token' => $token,
		]);

		$this->assertTrue(Hash::check('password', $user->password));

		$response->assertRedirect(route(self::ROUTE_PASSWORD_RESET, ['token' => $token, 'email' => $user->email]));
	}

	public function test_change_pwd_succeeds_if_valid_token_and_email()
	{
		$this->seed();
		$user = User::factory()->create([
			'email' => 'test@intradef.gouv.fr',
		]);
		$this->assertTrue(Hash::check('password', $user->password));

		$token = Password::broker()->createToken($user);
		$this->assertTrue(Password::broker()->tokenExists($user, $token));

		$response = $this->get(route(self::ROUTE_PASSWORD_RESET, ['token' => $token, 'email' => $user->email]))
			->assertSuccessful();

		$response = $this->post(route(self::ROUTE_PASSWORD_RESET_SUBMIT), [
			'email' => $user->email,
			'password' => "newpassword",
			'password_confirmation' => "newpassword",
			'token' => $token,
		]);

		$this->assertFalse(Password::broker()->tokenExists($user, $token));

		$user->refresh();
		$this->assertTrue(Hash::check('newpassword', $user->password));
		$response->assertSuccessful();
		$response->assertViewIs('auth.login');
	}
}
