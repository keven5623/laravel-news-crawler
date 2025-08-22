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
        // 每分鐘執行爬蟲
        $schedule->call(function () {
            Log::info('Scheduler triggered at ' . now());

            // 執行 docker-compose run crawler
            $output = [];
            $returnVar = null;

            exec('docker-compose run --rm crawler 2>&1', $output, $returnVar);

            // 檢查執行結果
            if ($returnVar !== 0) {
                Log::error('Crawler failed at ' . now() . ' with exit code ' . $returnVar);
                Log::error('Crawler output: ' . implode("\n", $output));
            } else {
                Log::info('Crawler succeeded at ' . now());
                Log::info('Crawler output: ' . implode("\n", $output));
            }
        })->everyMinute()
        ->withoutOverlapping()
        ->evenInMaintenanceMode();
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
