<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class MailsTest extends DuskTestCase
{

    public function test_mails_page_displays()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->loginAs($user)
                  ->visit(route('mails.index'))
                  ->assertSee('Mails');
        });
        
        $user->forceDelete();
    }

    // @test
    public function test_create_and_save_new_mail()
    {
        $user=User::factory()->create();
        $user->assignRole("admin");
        
        $this->browse(function ($browser)  use ($user){
            $browser->loginAs($user)
                  ->visit(route('mails.index'))
                  ->click('@create-mail-btn')
                  ->assertPathIs('/' . env('APP_PREFIX') .'/mails/create')
                  ->type('@input-sujet', 'TestTestTest')
                  ->click('@input-enregistrer-btn')
                  ->click('@input-retour-btn')
                  ->assertPathIs('/' . env('APP_PREFIX') .'/mails')
                  ->assertSee(('TestTestTest'));
        });
        
        $user->forceDelete();
    }

    public function test_mails_dummy_test()
    {
        $this->assertTrue(true);
    }
}
