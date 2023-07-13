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
        $user->admin = true;
        $user->save();
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('mails.index'))
                  ->assertSee('Mails');
        });
        
        $user->forceDelete();
    }

    // @test
    public function test_create_and_save_new_mail()
    {
        $user=User::factory()->create();
        $user->admin = true;
        $user->save();
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('mails.index'))
                  ->click('@create-mail-btn')
                  ->assertPathIs('/' . env('APP_PREFIX') .'/mails/create')
                  ->type('@input-sujet', 'TestTestTest')
		->pause(1000)
                  ->click('@input-enregistrer-btn')
		->pause(1000)
                  ->click('@input-retour-btn')
		->pause(1000)
                  ->assertPathIs('/' . env('APP_PREFIX') .'/mails')
                  ->assertSee('TestTestTest');
        });
        
        $user->forceDelete();
    }
}
