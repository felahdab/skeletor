<?php

namespace App\Console;

use App\Jobs\AdjustDisplayNames;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:prune-batches')->hourly();
        $schedule->job(new AdjustDisplayNames())->daily();

        $schedule->command('backup:clean')->daily()->at('07:00');
        $schedule->command('backup:run')->daily()->at('07:15');
        $schedule->command('skeletor:get-rabbitmq-messages --limit=100')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require_once base_path('routes/console.php');
    }
}
