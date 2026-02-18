<?php

namespace Mhmiton\LaravelModulesLivewire\Tests\Traits;

use Illuminate\Support\Facades\File;

trait InitModule
{
    protected function setUpModule(): void
    {
        $this->createTestModule();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->cleanupTestModule();
    }

    protected function createTestModule()
    {
        // Ensure modules directory exists for testing
        if (! is_dir(base_path('Modules'))) {
            mkdir(base_path('Modules'), 0777, true);
        }

        $this->artisan('module:make', ['name' => ['Core'], '--force' => true]);

        $this->assertTrue($this->hasTestModule(), 'Module was not created');
    }

    protected function cleanupTestModule()
    {
        if ($this->hasTestModule()) {
            File::deleteDirectory(base_path('Modules/Core'));

            file_put_contents(
                base_path('modules_statuses.json'),
                '{}'
            );
        }
    }

    protected function hasTestModule()
    {
        return File::exists(base_path('Modules/Core/module.json'));
    }
}
