<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::command('app:calculate-weekly-connecteam-hours')
//     ->weeklyOn(7, '23:59') // Sunday at 11:59 PM
//     ->withoutOverlapping();

Schedule::command('app:calculate-weekly-connecteam-hours')
    ->everyMinute();
