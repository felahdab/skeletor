<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Illuminate\Contracts\Console\PromptsForMissingInput;

class PublishModuleDocumentationIntoLarecipe extends Command implements PromptsForMissingInput
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'skeletor:publish-module-doc';

    protected $signature = 'skeletor:publish-module-doc {module} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish a module\'s documentation files to the main resources/doc directory';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->components->info('publishing module documentation files...');

        if ($module = $this->argument('module')) {
            $this->publishConfiguration($module);

            return 0;
        }

        foreach ($this->laravel['modules']->allEnabled() as $module) {
            $this->publishConfiguration($module->getName());
        }

        return 0;
    }

    /**
     * @param string $module
     * @return string
     */
    private function getServiceProviderForModule($module)
    {
        $namespace = $this->laravel['config']->get('modules.namespace');
        $studlyName = Str::studly($module);

        return "$namespace\\$studlyName\\Providers\\{$studlyName}ServiceProvider";
    }

    /**
     * @param string $module
     */
    private function publishConfiguration($module)
    {
        $this->call('vendor:publish', [
            '--provider' => $this->getServiceProviderForModule($module),
            '--force' => true,
            '--tag' => ['doc'],
        ]);

        # TODO: c'est là qu'il faut ajuster comment on intègre la doc 
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of module being used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['--force', '-f', InputOption::VALUE_NONE, 'Force the publishing of config files'],
        ];
    }
}
