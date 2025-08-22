<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Artisan 命令清單
     *
     * @var array<int, class-string|string>
     */
    protected $commands = [
        // 自訂命令在這裡註冊，例如：
        // \App\Console\Commands\MyCommand::class,
    ];

    /**
     * 定義任務排程
     */
    protected function schedule(Schedule $schedule): void
    {
        // 每分鐘執行排程
        $schedule->call(function () {
            Log::info('Scheduler triggered at ' . now());

            exec('docker-compose run --rm crawler');
        })->everyMinute();
    }

    /**
     * 註冊命令
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
