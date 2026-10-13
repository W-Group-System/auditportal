<?php

namespace App\Console;

use App\Console\Commands\getReport;
use App\Console\Commands\send_email;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        getReport::class,
        send_email::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('command:get_reports')->everyMinute();
        # Run the comman every 15th and last monday of the month
        // $schedule->command('command:actionplan_report')->monthlyOn(22, '8:00');
        $schedule->command('command:actionplan_report')->monthlyOn(15, '8:00');
        $schedule->command('command:actionplan_report')
         ->weeklyOn(1, '8:00')
         ->when(function () {
             return now()->addWeek()->month !== now()->month;
         });
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
