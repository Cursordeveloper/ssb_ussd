<?php

declare(strict_types=1);

namespace Domain\User\Guest\Jobs\Registration;

use App\Services\Customer\Requests\Customer\CustomerServiceCustomerCreateRequest;
use App\Services\Mobile\Requests\MobileServiceCustomerCreateRequest;
use Domain\User\Customer\Models\Customer;
use Domain\User\Guest\Data\Registration\CustomerData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CustomerRegistrationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected readonly Customer $customer)
    {
    }

    public function handle(): void
    {
        // Define the message data
        $data = CustomerData::toArray(customer: $this->customer);

        // Publish message through http
        (new CustomerServiceCustomerCreateRequest)->execute(data: $data);
        (new MobileServiceCustomerCreateRequest)->execute(data: $data);
    }
}
