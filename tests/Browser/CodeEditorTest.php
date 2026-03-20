<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class CodeEditorTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testCodeEditorLoginDisplays()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(env('APP_PREFIX').'/code-editor')
                ->assertSee('code-server')
            ;
        });
    }
}
