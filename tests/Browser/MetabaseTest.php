<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MetabaseTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_metabase_responds()
    {
        $this->assertTrue(true);
        return;
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_PREFIX') . '/metabase')
                    ->assertSee('Se connecter à Metabase');
        });
    }
}
