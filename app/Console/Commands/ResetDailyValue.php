<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetDailyValue extends Command
{
    protected $signature = 'app:reset-daily-value';
    protected $description = 'Reset addedToday and deletedToday in the settings table daily';

    public function handle()
    {
        // Reset addedToday and deletedToday for all rows in the settings table
        DB::table('settings')->update(['addedToday' => 0, 'deletedToday' => 0]);

        $this->info('Daily values (addedToday and deletedToday) have been reset successfully.');
    }
}
