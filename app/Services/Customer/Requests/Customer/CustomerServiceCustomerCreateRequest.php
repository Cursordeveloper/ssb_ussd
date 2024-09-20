<?php

declare(strict_types=1);

namespace App\Services\Customer\Requests\Customer;

use App\Services\Customer\CustomerService;
use Illuminate\Support\Facades\Http;

final class CustomerServiceCustomerCreateRequest
{
    public CustomerService $service;

    public function __construct()
    {
        $this->service = new CustomerService;
    }

    public function execute(array $data): void
    {
        Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
            ->post(url: $this->service->base_url.'registrations', data: $data)
            ->json();
    }
}
