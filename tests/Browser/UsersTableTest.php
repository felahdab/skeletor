<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class UsersTableTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_users_table_gestion_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                  ->loginAs($user)
                  ->visit(route('users.index'))
                  ->assertSee('Marins');
        });
        
        $user->forceDelete();
    }

    public function test_users_table_gestion_search()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                ->loginAs($user)
                  ->visit(route('users.index'))
                  ->assertSee('Marins')
                  ->keys("div.input-group:nth-child(1) > input:nth-child(1)", "ADMIN")
                  ->pause(1000)
                  ->assertSee("Admin")
                  ->assertDontSee("ZA");
        });
        
        $user->forceDelete();
    }

    public function test_users_deletion_fails_if_not_date_debarq()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $otheruser=User::factory()->create();
        $otheruser->assignRole("user");
        $otheruser->name="toto";
        $otheruser->save();

        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                    ->visit(route('users.index'))
                    ->assertSee('Marins')
                    ->keys("div.input-group:nth-child(1) > input:nth-child(1)", "TOTO")
                    ->pause(1000)
                    ->assertSee("toto")
                    ->assertDontSee("ZA")
                    ->click("@delete-btn")
                    ->assertSee("Vous devez renseigner la date de débarquement avant de supprimer un utilisateur.");
        });
        
        $user->forceDelete();
        $otheruser->forceDelete();
    }

    public function test_users_deletion_succeeds_if_date_debarq()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");

        $otheruser=User::factory()->create();
        $otheruser->assignRole("user");
        $otheruser->name="toto";
        $otheruser->date_debarq="2022/01/01";
        $otheruser->save();
       
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                    ->visit(route('users.index'))
                    ->assertSee('Marins')
                    ->keys("div.input-group:nth-child(1) > input:nth-child(1)", "TOTO")
                    ->pause(1000)
                    ->assertSee("toto")
                    ->click("@delete-btn")
                    ->pause(1000)
                    ->assertSee("Utilisateur supprimé");
        });
        
        $user->forceDelete();
        $otheruser->forceDelete();

    }
}
