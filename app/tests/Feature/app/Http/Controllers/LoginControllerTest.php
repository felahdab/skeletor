<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class LoginControllerTest extends TestCase
{
	use RefreshDatabase;    


    public function test_locallogin_page()
    {
//            print_r(route('login.show'));    
	    $response = $this->get(route('login.show'));

        $response->assertStatus(200);
    }

	public function test_login_failure(){
 //           print_r(route('login.perform'));    
		$this->seed(); 
		$user=User::factory()->create();
		$response = $this->post(route('login.perform'), [
			'email' => $user->email,
			'password' => 'zboobie'
		]);
		$response->assertRedirect(route('login.show'));
	}

	public function test_login_success(){
		//          print_r(route('login.perform'));   
		$this->seed(); 
		$user=User::factory()->create();
		$response = $this->post(route('login.perform'), [
			'email' => $user->email,
			'password' => 'password'
		]);
		$response->assertRedirect(route('home.index'));
	}
}
