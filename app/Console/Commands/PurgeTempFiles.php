<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class PurgeTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transformation:purge:tempFiles';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge temporary files from the storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directoryPath = storage_path('app/public/transformation_tmp/');
        if(File::exists($directoryPath)){
            $files = File::allFiles($directoryPath);

            foreach($files as $file){
                File::delete($file);
            }

            $this->info("Tous les fichiers temporaires ont été supprimés");
        }else{
            $this->error("Le répertoire n'existe pas");
        }
    }
}
