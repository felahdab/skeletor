<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PhpmyadminTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_phpmyadin_homepage_displays()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                    ->visit(env('APP_PREFIX') . '/pma')
                    ->assertSee('phpMyAdmin');
        });
    }
}
