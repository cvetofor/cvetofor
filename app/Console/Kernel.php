<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->command('tender:cron')->everyFiveMinutes();
        $schedule->command('marketplace:payments')->weeklyOn(1, '00:01');
        $schedule->job(new \App\Jobs\TelegramGetUpdates)->everyMinute();

        // Очистка кеша каждый час
        $schedule->command('cache:clear')->hourly();

        // Очистка конфигурационного кеша каждый час
        $schedule->command('config:clear')->hourly();

        // Очистка кеша маршрутов каждый час
        $schedule->command('route:clear')->hourly();

        // Очистка кеша представлений каждый час
        $schedule->command('view:clear')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
