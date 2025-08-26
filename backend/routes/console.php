<?php


use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


app()->booted(function () {
    $schedule = app()->make(Schedule::class);

    $schedule->call(function () {
        Log::info('Scheduler triggered at ' . now());

        $output = [];
        $returnVar = null;
        // exec('docker-compose run --rm crawler 2>&1', $output, $returnVar);
        exec('python3 /var/www/crawler/news_crawler.py 2>&1', $output, $returnVar);

        if ($returnVar !== 0) {
            Log::error('Crawler failed at ' . now() . ' with exit code ' . $returnVar);
            Log::error('Crawler output: ' . implode("\n", $output));
        } else {
            Log::info('Crawler succeeded at ' . now());
            Log::info('Crawler output: ' . implode("\n", $output));
        }
    })->name('crawler-schedule')
      ->everyMinute()
      ->withoutOverlapping()
      ->evenInMaintenanceMode();

});