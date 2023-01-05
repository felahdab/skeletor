<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Lien;

class LienControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_lien_index_succeeds()
    {
        $this->seed();
        $user=User::find(1);
        $response = $this->actingAs($user)
              ->get(route('liens.index'));

        $response->assertStatus(200);
    }
    
    public function test_lien_create_succeeds()
    {
        $this->seed();
        $user=User::find(1);
        $response = $this->actingAs($user)
              ->get(route('liens.create'));

        $response->assertStatus(200);
    }
    
    public function test_lien_store_succeeds()
    {
        $this->seed();
        $user=User::find(1);
        $response = $this->actingAs($user)
              ->post(route('liens.store') , ["lien_lib" => "libelle", 
                                            "lien_url" => "http://url"]);

        $response->assertRedirect();
        $this->assertDatabaseHas('liens', ['lien_lib' => 'libelle']);
    }
    
    public function test_lien_delete_succeeds()
    {
        $this->seed();
        
        $lien = Lien::factory()->create();
        
        $this->assertDatabaseHas('liens', ["id" => $lien->id] );
        
        $user=User::find(1);

        $response = $this->actingAs($user)
              ->delete(route('liens.destroy', ['lien' => $lien ])); 
    
        $this->assertDatabaseMissing('liens', ["id" => $lien->id] );

    }
}
