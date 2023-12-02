<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\MessageConsumer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ShortSchedule\ShortSchedule;

final class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
    }

    protected function shortSchedule(ShortSchedule $shortSchedule): void
    {
        $shortSchedule->command(command: MessageConsumer::class)->everySecond()->withoutOverlapping();
    }

    protected function commands(): void
    {
        $this->load(paths: __DIR__.'/Commands');
    }
}
