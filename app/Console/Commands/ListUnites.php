<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Unite;

class ListUnites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:list-units';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->table(
            ['id', 'unite_libcourt'],
            Unite::all('id', 'unite_libcourt')->toArray()
        );
        return 0;
    }
}
