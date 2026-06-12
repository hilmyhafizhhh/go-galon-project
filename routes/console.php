<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('orders:cancel-expired')
    ->dailyAt('00:00')
    ->timezone('Asia/Jakarta');

Schedule::command('chats:cleanup')
    ->dailyAt('00:00')
    ->timezone('Asia/Jakarta');