<?php

namespace app\Console;

use app\Models\mReminderSetting;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        /**
//         * Reminder Consult Run
//         */
//
//        $consult_target_hour = mReminderSetting::select('target_hour')->where('variable', 'reminder_consult')->value('target_hour');
//        $consult_target_hour = date('H:i', strtotime($consult_target_hour));
//        $schedule->call('app\Http\Controllers\General\Reminder@consult')->dailyAt($consult_target_hour);
//
//        /**
//         * Reminder Action Run
//         */
//
//        $action_target_hour = mReminderSetting::select('target_hour')->where('variable', 'reminder_action')->value('target_hour');
//        $action_target_hour = date('H:i', strtotime($action_target_hour));
//        $schedule->call('app\Http\Controllers\General\Reminder@action')->dailyAt($action_target_hour);
//
//        /**
//         * Reminder Control Run
//         */
//
//        $control_target_hour = mReminderSetting::select('target_hour')->where('variable', 'reminder_control')->value('target_hour');
//        $control_target_hour = date('H:i', strtotime($control_target_hour));
//        $schedule->call('app\Http\Controllers\General\Reminder@control')->dailyAt($control_target_hour);
//
//        /**
//         * Reminder Birthday Run
//         */
//
//        $birthday_target_hour = mReminderSetting::select('target_hour')->where('variable', 'reminder_birthday')->value('target_hour');
//        $birthday_target_hour = date('H:i', strtotime($birthday_target_hour));
//        $schedule->call('app\Http\Controllers\General\Reminder@birthday')->dailyAt($birthday_target_hour);
//
//        /**
//         * Reminder Schedule Run
//         */
//
//        $schedule_target_hour = mReminderSetting::select('target_hour')->where('variable', 'reminder_schedule')->value('target_hour');
//        $schedule_target_hour = date('H:i', strtotime($schedule_target_hour));
//        $schedule->call('app\Http\Controllers\General\Reminder@schedule')->dailyAt($schedule_target_hour);

        $schedule->call('app\Http\Controllers\General\Reminder@test_cron_job')->everyMinute();

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
