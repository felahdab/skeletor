<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class MigrateDatabaseCommand extends Command
{
    protected $signature = 'skeletor:migrate-database {table}';

    public function handle()
    {

        if (config('database.connections.source') == null || config('database.connections.destination') == null){
            $this->fail("Source or destination database connections are undefined.");
        }

        $table = $this->argument('table');

        $this->info("Importing table {$table}");

        $total = DB::connection('source')
            ->table($table)
            ->count();
        $this->info($total . " total records to transfer.");

        $records = DB::connection('source')
            ->table($table)
            ->get();

        $records = $records->map(function($item) {
            return json_decode(json_encode($item), true);;
        })->toArray();

        DB::connection('destination')->table($table)->insert($records);

    }
}