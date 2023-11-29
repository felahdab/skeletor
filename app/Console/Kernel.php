<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Jobs\AdjustDisplayNames;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:prune-batches')->hourly();
        $schedule->job(new AdjustDisplayNames)->daily();

        $schedule->command('backup:clean')->daily()->at('07:00');
        $schedule->command('backup:run')->daily()->at('07:15');
        
        $schedule->command('transformation:purge:tempFiles')->daily()->at('07:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
