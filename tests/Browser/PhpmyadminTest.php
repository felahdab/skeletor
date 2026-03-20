<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class PhpmyadminTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testPhpmyadinHomepageDisplays()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(env('APP_PREFIX').'/pma')
                ->assertSee('phpMyAdmin')
            ;
        });
    }
}
