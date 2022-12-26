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
    public function test_users_table_gestion()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                  ->visit(route('users.index'))
                  ->assertSee('Marins');
        });
        
    }
}
