<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UsersControllerTest extends TestCase
{
	use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_index_redirect_when_not_logged_in()
    {
	    $this->seed();
        $response = $this->get(route('users.index'));

        $response->assertStatus(302);
    }
	 
    public function test_user_index_succeeds()
    {
	    $this->seed();
	    $user=User::find(1);
	    $response = $this->actingAs($user)
		      ->get(route('users.index'));

        $response->assertStatus(200);
    }

    public function test_user_creation_when_admin_succeeds()
    {
	    $this->seed();
	    $user=User::find(1);
	    $response = $this->actingAs($user)
		      ->post(route('users.create'), [
            'name' => 'nom',
            'prenom' => 'prenom',
            'email' =>  'test@intradef.gouv.fr',
            'date_embarq' => '2022/07/10', 
            'grade_id' => 10,
		      ]);

	    $response->assertStatus(200);
	    $this->assertDatabaseHas('users', ['name' => 'NOM']);

	    return 'NOM';
    }

     public function test_user_creation_when_logged_in_fails_if_incomplete_request()
    {
	    $this->seed();
	    $user=User::find(1);
	    $response = $this->actingAs($user)
		      ->post(route('users.create'), [
            'name' => 'nom',
            'email' =>  'test@intradef.gouv.fr',
            'date_embarq' => '2022/07/10', 
            'grade_id' => 10,
		      ]);

	    $response->assertInvalid(['prenom']);
    }

     public function test_user_creation_when_logged_in_fails_if_invalid_email()
    {
	    $this->seed();
	    $user=User::find(1);
	    $response = $this->actingAs($user)
		      ->post(route('users.create'), [
            'name' => 'nom',
            'prenom' => 'prenom',
            'email' =>  'test@example.com',
            'date_embarq' => '2022/07/10', 
            'grade_id' => 10,
		      ]);

	    $response->assertInvalid(['email']);
    }

    public function test_created_user_has_user_role()
    {
	    $this->seed();
	    $user=User::find(1);
	    $response = $this->actingAs($user)
		      ->post(route('users.create'), [
            'name' => 'nom',
            'prenom' => 'prenom',
            'email' =>  'test@intradef.gouv.fr',
            'date_embarq' => '2022/07/10', 
            'grade_id' => 10,
		      ]);

	    $response->assertStatus(200);
	    $this->assertDatabaseHas('users', ['name' => 'NOM']);
	    $newUser=User::where('name', 'NOM')->first();
	    $this->assertTrue($newUser->hasRole('user'));
    }
    
    public function test_deletion_of_created_user_when_admin_succeeds()
    {
	    $this->seed();
	    $user=User::find(1);

	    $newUser = User::factory()->create();

        $newUser->date_debarq="maintenant";
        $newUser->save();

	    $response = $this->actingAs($user)
		    ->delete(route('users.destroy', ['user' => $newUser])); 
	    $this->assertSoftDeleted($newUser);
    }

    public function test_deletion_of_created_user_when_not_admin_fails()
    {
	    $this->seed();

	    $newUser = User::factory()->create();

	    $response = $this->delete(route('users.destroy', ['user' => $newUser])); 
	    $response->assertRedirect();
    }

}
