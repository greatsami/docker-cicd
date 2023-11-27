<?php

namespace App\Console;

use App\Jobs\PublishPostsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(PublishPostsJob::class)->everyMinute();

        $schedule->command('backup:clean')->daily()->at('01:00');

        $schedule->command('backup:run')->daily()->at('01:30');

        // * * * * * cd /home/sami/sites/Docker/posts-project/api && php artisan schedule:run >> /dev/null 2>&1
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
