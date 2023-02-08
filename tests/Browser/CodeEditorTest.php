<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CodeEditorTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_code_editor_login_displays()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_PREFIX') . '/code-editor')
                    ->assertSee('code-server');
        });
    }
}
