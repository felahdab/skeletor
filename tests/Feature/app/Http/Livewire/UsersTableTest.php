<?php

namespace Tests\Feature\app\Http\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Livewire;
use App\Models\User;
use App\Http\Livewire\UsersTable;

class UsersTableTest extends TestCase
{
	use RefreshDatabase;
	
	public function test_users_table_component_when_logged_in()
    {
	    $this->seed();
	    $admin= User::find(1);
	    $response = $this->actingAs($admin)->get(route('users.index'));
	    $response->assertSeeLivewire('users-table');
    } 
	
}
