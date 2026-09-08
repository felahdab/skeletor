<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class SkeletorSeedPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:seed-permissions {module? : Nom du module (ex: FcmCentral). Si omis, exécute le PermissionsSeeder de tous les modules activés.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exécute le PermissionsSeeder d\'un module (ou de tous les modules activés si aucun n\'est précisé).';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $moduleName = $this->argument('module');

        if ($moduleName) {
            return $this->seedModule($moduleName) ? self::SUCCESS : self::FAILURE;
        }

        $modules = Module::allEnabled();
        $succes = [];
        $ignores = [];

        foreach ($modules as $module) {
            $nom = $module->getName();

            if ($this->classeSeederExiste($nom)) {
                $this->seedModule($nom);
                $succes[] = $nom;
            } else {
                $ignores[] = $nom;
            }
        }

        $this->newLine();
        $this->info('Modules seedés : '.(empty($succes) ? '(aucun)' : implode(', ', $succes)));

        if (!empty($ignores)) {
            $this->comment('Modules ignorés (pas de PermissionsSeeder) : '.implode(', ', $ignores));
        }

        return self::SUCCESS;
    }

    private function classeSeederExiste(string $moduleName): bool
    {
        return class_exists("Modules\\{$moduleName}\\Database\\Seeders\\PermissionsSeeder");
    }

    private function seedModule(string $moduleName): bool
    {
        $classe = "Modules\\{$moduleName}\\Database\\Seeders\\PermissionsSeeder";

        if (!class_exists($classe)) {
            $this->error("Aucun PermissionsSeeder trouvé pour le module \"{$moduleName}\" ({$classe} n'existe pas).");

            return false;
        }

        $this->info("Seed des permissions du module \"{$moduleName}\"...");
        Artisan::call('db:seed', ['--class' => $classe, '--force' => true]);
        $this->line(Artisan::output());

        return true;
    }
}
