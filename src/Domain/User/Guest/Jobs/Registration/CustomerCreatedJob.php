<?php

declare(strict_types=1);

namespace Domain\User\Guest\Jobs\Registration;

use Domain\User\Guest\Actions\Registration\CustomerCreatedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CustomerCreatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected readonly array $request)
    {
    }

    public function handle(): void
    {
        // Create the customer
        CustomerCreatedAction::execute(request: $this->request);
    }
}
