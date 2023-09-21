<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(command: 'app:message-consumer')->everySecond();
    }

    protected function commands(): void
    {
        $this->load(paths: __DIR__.'/Commands');
    }
}
