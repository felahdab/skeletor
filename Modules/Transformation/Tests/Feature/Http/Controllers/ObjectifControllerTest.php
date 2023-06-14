<?php

namespace Modules\Transformation\Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class ObjectifControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_objectif_index_fails_when_not_logged_in()
    {
        $response = $this->get(route('objectifs.index'));

        $response->assertRedirect(route('home.index'));
    }

    public function test_objectif_index_succeeds_when_logged_in()
    {
        $this->seed();
	    $user=User::find(1);
	    $response = $this->actingAs($user)
		      ->get(route('objectifs.index'));

        $response->assertStatus(200);
    }

    
}
