<?php

declare(strict_types=1);

namespace App\Services\Customer\Requests\Kyc;

use App\Services\Customer\CustomerService;
use Domain\User\Customer\Models\Customer;
use Illuminate\Support\Facades\Http;

final class CustomerServiceLinkGhanaCardCancellationRequest
{
    public CustomerService $service;

    public function __construct()
    {
        $this->service = new CustomerService;
    }

    public function execute(Customer $customer, string $kyc_resource, array $data): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
            ->post(url: $this->service->base_url.$customer->resource_id.'/kycs/'.$kyc_resource.'/cancellations', data: $data)
            ->json();
    }
}
