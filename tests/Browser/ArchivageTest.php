<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Mail;

use App\Models\User;

class ArchivageTest extends DuskTestCase
{

    public function test_archivage_page_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->loginAs($user)
                  ->visit(route('archivage.index'))
                  ->assertSee('Marins à archiver');
        });
        
        $user->forceDelete();
    }

    public function test_soft_deleted_user_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");

        $otheruser=User::factory()->create();
        $otheruser->assignRole("user");
        $otheruser->name="toto";
        $otheruser->date_debarq="2022/01/01";
        $otheruser->save();
        $otheruser->delete();
        
        $this->browse(function ($browser)  use ($user, $otheruser){
            $browser->loginAs($user)
                  ->visit(route('archivage.index'))
                  ->assertSee($otheruser->name);
        });
        
        $user->forceDelete();
        $otheruser->forceDelete();
    }

    public function test_soft_deleted_user_is_restored_with_data()
    {
        Mail::fake();

        $user=User::factory()->create();
        $user->assignRole("admin");

        $otheruser=User::factory()->create();
        $otheruser->assignRole("user");
        $otheruser->name="avecdata";
        $otheruser->date_debarq="2022/01/01";
        $otheruser->save();
        $otheruser->delete();
        
        $this->browse(function ($browser)  use ($user, $otheruser){
            $browser->loginAs($user)
                  ->visit(route('archivage.index'))
                  ->keys(".form-control", $otheruser->name)
                  ->pause(1000)
                  ->assertSee($otheruser->name)
                  ->click('@restaurer-avec-btn')
                  ->assertSee('Utilisateur restauré')
                  ->assertDontSee($otheruser->name);
        });

        $postuser = User::where('name', $otheruser->name)->first();
        $this->assertTrue($postuser != null);
        $this->assertTrue($postuser->id == $otheruser->id);
        
        $user->forceDelete();
        $otheruser->forceDelete();
    }

    public function test_soft_deleted_user_is_restored_without_data()
    {
        Mail::fake();
        
        $user=User::factory()->create();
        $user->assignRole("admin");

        $otheruser=User::factory()->create();
        $otheruser->assignRole("user");
        $otheruser->name="sansdata";
        $otheruser->date_debarq="2022/01/01";
        $otheruser->save();
        $otheruser->delete();
        
        $this->browse(function ($browser)  use ($user, $otheruser){
            $browser->loginAs($user)
                  ->visit(route('archivage.index'))
                  ->keys(".form-control", $otheruser->name)
                  ->pause(1000)
                  ->assertSee($otheruser->name)
                  ->click('@restaurer-sans-btn')
                  ->assertSee('Utilisateur restauré')
                  ->assertDontSee($otheruser->name);
        });

        $postuser = User::where('name', $otheruser->name)->first();
        $this->assertTrue($postuser != null);
        $this->assertTrue($postuser->id != $otheruser->id);
        
        $user->forceDelete();
        $postuser->forceDelete();
        $otheruser->forceDelete();
    }

    public function test_soft_deleted_user_cannot_be_deleted_if_not_date_archivage()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");

        $otheruser=User::factory()->create();
        $otheruser->assignRole("user");
        $otheruser->name="sansarchivage";
        $otheruser->date_debarq="2022/01/01";
        $otheruser->date_archivage=null;
        $otheruser->save();
        $otheruser->delete();
        
        $this->browse(function ($browser)  use ($user, $otheruser){
            $browser->loginAs($user)
                  ->visit(route('archivage.index'))
                  ->keys(".form-control", $otheruser->name)
                  ->pause(1000)
                  ->assertSee($otheruser->name)
                  ->assertDontSee("Supprimer totalement");
        });
        
        $user->forceDelete();
        $otheruser->forceDelete();
    }

    public function test_soft_deleted_user_without_date_archivage_can_be_deleted_after_archivage()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");

        $otheruser=User::factory()->create();
        $otheruser->assignRole("user");
        $otheruser->name="sansarchivage";
        $otheruser->date_debarq="2022/01/01";
        $otheruser->date_archivage=null;
        $otheruser->save();
        $otheruser->delete();
        
        $this->browse(function ($browser)  use ($user, $otheruser){
            $browser->loginAs($user)
                  ->visit(route('archivage.index'))
                  ->keys(".form-control", $otheruser->name)
                  ->pause(1000)
                  ->assertSee($otheruser->name)
                  ->assertDontSee("Supprimer totalement")
                  ->click('@archiver-btn')
                  ->pause(2000)
                  ->assertSee("Supprimer totalement");
        });
        
        $user->forceDelete();
        $otheruser->forceDelete();
    }

    public function test_soft_deleted_user_with_date_archivage_can_be_force_deleted()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");

        $otheruser=User::factory()->create();
        $otheruser->assignRole("user");
        $otheruser->name="sansarchivage";
        $otheruser->date_debarq="2022/01/01";
        $otheruser->date_archivage="2022/01/01";
        $otheruser->save();
        $otheruser->delete();
        
        $this->browse(function ($browser)  use ($user, $otheruser){
            $browser->loginAs($user)
                  ->visit(route('archivage.index'))
                  ->keys(".form-control", $otheruser->name)
                  ->pause(1000)
                  ->assertSee($otheruser->name)
                  ->assertSee("Supprimer totalement")
                  ->click('@really-delete-btn')
                  ->pause(2000)
                  ->assertSee("Utilisateur supprimé");
        });

        $this->assertDatabaseMissing('users', ['name' => "sansarchivage" ]);        
        $user->forceDelete();
    }
}
