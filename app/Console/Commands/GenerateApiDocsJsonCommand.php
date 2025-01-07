<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Artisan;


class GenerateApiDocsJsonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:generate-api-docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cette commande génère le fichier api-docs.json nécessaire pour le fonctionnement de SwaggerUI.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         *  Cette commande repose sur scramble:export qui réalise le plus gros du travail.
         *  Puis, cette commande récupère le fichier api-docs.json et le nettoie pour que le rendu avec swagger UI soit plus
         *  propre.
         */
        Artisan::call('scramble:export');

        $apidocspath = config('scramble.export_path');
        $api_doc = json_decode(file_get_contents($apidocspath), true);

        foreach ($api_doc["paths"] as $path => $path_description)
        {
            foreach ($path_description as $method => $method_description){
                $tags = Arr::get($api_doc, "paths." . $path. "." . $method . ".tags");

                $maxlength = max(array_map('strlen', $tags));
                $longest_tag = array_filter($tags, function($value) use ($maxlength){
                    return strlen($value) === $maxlength;
                });

                Arr::set($api_doc, "paths." . $path. "." . $method . ".tags", [ $longest_tag ]);
            }
        }
        
        file_put_contents($apidocspath, json_encode($api_doc));
    }
}
