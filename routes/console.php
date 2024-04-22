<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:update-users')->everyMinute()->sendOutputTo('update-users.log');
//* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
