<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\File;

use Illuminate\Console\Command;

class CreateStorageForModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create-storage-for-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crée un dossier de stockage dédié au module voulu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = $this->argument('name');
        $storagePath = storage_path('app/public/' .  strtolower($moduleName));

        if(!File::exists($storagePath)){
            File::makeDirectory($storagePath, 0755, true);
            $this->info("Dossier de stockage créé : " . $storagePath);
        }
        else{
            $this->error("Le dossier de stockage existe déjà");
        }
    }
}
