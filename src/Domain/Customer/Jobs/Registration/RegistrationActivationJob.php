<?php

declare(strict_types=1);

namespace Domain\Customer\Jobs\Registration;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class RegistrationActivationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param array $request
     */
    public function __construct(
        private readonly array $request
    ) {
    }

    public function handle(): void
    {
        // Get the customer

        // Activate the customer account account

        // Publish the RegistrationActivatedEvent to the ssb_notification_service

        // Delete the token after activation
    }
}
