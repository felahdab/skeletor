<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateDatabaseCommand extends Command
{
    protected $signature = 'skeletor:migrate-database {table}';

    protected $description = 'Réalise la migration des données de la table passée en paramètres depuis la base "source" vers la base "destination".';

    public function handle()
    {
        if (null == config('database.connections.source') || null == config('database.connections.destination')) {
            $this->fail('Source or destination database connections are undefined.');
        }

        $table = $this->argument('table');

        $this->info("Importing table {$table}");

        $total = DB::connection('source')
            ->table($table)
            ->count()
        ;
        $this->info($total.' total records to transfer.');

        $records = DB::connection('source')
            ->table($table)
            ->get()
        ;

        $records = $records->map(function ($item) {
            return json_decode(json_encode($item), true);
        })->toArray();

        DB::connection('destination')->table($table)->insert($records);
    }
}
