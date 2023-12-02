<?php

declare(strict_types=1);

namespace App\Services\Customer\Requests;

use App\Services\Customer\CustomerService;
use Illuminate\Support\Facades\Http;

final class StoreCustomer extends CustomerService
{
    public function execute(array $data): void
    {
        Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->post(
            url: $this->base_url, data: $data
        )->json();
    }
}
