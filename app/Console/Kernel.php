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

        $schedule->command('cache:clear')
            ->hourly()
            // ->everyMinute()
            ->appendOutputTo(storage_path('logs/optimize-clear.log'))
            ->before(function () {
                file_put_contents(
                    storage_path('logs/optimize-clear.log'),
                    "[" . date('Y-m-d H:i:s') . "] Начинаем очистку кэша: останавливаем php-fpm\n",
                    FILE_APPEND
                );

                // Останавливаем PHP-FPM перед очисткой кэша
                exec('sudo systemctl stop php8.1-fpm');
            })
            ->after(function () {
                // Запускаем PHP-FPM после завершения
                exec('sudo systemctl start php8.1-fpm');
            });

        // Очистка конфигурационного кеша каждый час
        $schedule->command('config:clear')
            ->hourly()
            ->appendOutputTo(storage_path('logs/optimize-clear.log'));

        // Очистка кеша маршрутов каждый час
        $schedule->command('route:clear')
            ->hourly()
            ->appendOutputTo(storage_path('logs/optimize-clear.log'));

        // Очистка кеша представлений каждый час
        $schedule->command('view:clear')
            ->hourly()
            ->appendOutputTo(storage_path('logs/optimize-clear.log'))
            ->after(function () {
                // Добавляем временную метку после запуска php-fpm
                file_put_contents(
                    storage_path('logs/optimize-clear.log'),
                    "[" . date('Y-m-d H:i:s') . "] Завершили очистку кэша: запущен php-fpm\n" . PHP_EOL,
                    FILE_APPEND
                );
            });
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
