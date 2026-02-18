<?php

namespace Mhmiton\LaravelModulesLivewire\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\File;
use Mhmiton\LaravelModulesLivewire\Traits\LivewireComponentParser;

class LivewireMakeFormCommand extends Command implements PromptsForMissingInput
{
    use LivewireComponentParser;

    protected $signature = 'module:make-livewire-form {component} {module} {--force} {--stub=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Livewire Form Component.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! $this->parser()) {
            return false;
        }

        if (! $this->checkClassNameValid()) {
            return false;
        }

        if (! $this->checkReservedClassName()) {
            return false;
        }

        data_set(
            $this->component,
            'stub.class',
            strtr(data_get($this->component, 'stub.class'), ['livewire.stub' => 'livewire.form.stub'])
        );

        $class = $this->createClass();

        if ($class) {
            $this->line("<options=bold,reverse;fg=green> FORM COMPONENT CREATED </> 🤙\n");

            $class && $this->line("<options=bold;fg=green>CLASS:</> {$this->getClassSourcePath()}");
        }

        return false;
    }

    protected function createClass()
    {
        $classFile = $this->component->class->file;

        if (File::exists($classFile) && ! $this->isForce()) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS-IE-TOOTLES </> 😳 \n");
            $this->line("<fg=red;options=bold>Class already exists:</> {$this->getClassSourcePath()}");

            return false;
        }

        $this->ensureDirectoryExists($classFile);

        File::put($classFile, $this->getClassContents());

        return $this->component->class;
    }
}
