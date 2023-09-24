<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(command: 'app:message-consumer')->everySecond();
    }

    protected function commands(): void
    {
        $this->load(paths: __DIR__.'/Commands');
    }
}
