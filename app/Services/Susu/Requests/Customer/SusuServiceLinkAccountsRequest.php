<?php

declare(strict_types=1);

namespace App\Services\Susu\Requests\Customer;

use App\Services\Susu\SusuService;
use Domain\Shared\Models\Customer\Customer;
use Illuminate\Support\Facades\Http;

final class SusuServiceLinkAccountsRequest
{
    public SusuService $service;

    public function __construct()
    {
        $this->service = new SusuService;
    }

    public function execute(Customer $customer): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->get(
            url: $this->service->base_url.'customers/'.$customer->resource_id.'/linked-accounts',
        )->json();
    }
}
