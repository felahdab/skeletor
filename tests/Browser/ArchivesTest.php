<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\User;

class ArchivesTest extends DuskTestCase
{

    public function test_archives_page_displays()
    {
        $user=User::factory()->create();
        $user->admin = true;
        $user->save();
        
        $this->browse(function ($browser)  use ($user){
            $browser->maximize()
                    ->loginAs($user)
                  ->visit(route('archives.index'))
                  ->assertSee('Marins archivés');
        });
        
        $user->forceDelete();
    }
}
