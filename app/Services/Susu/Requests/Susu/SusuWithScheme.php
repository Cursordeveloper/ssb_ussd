<?php

declare(strict_types=1);

namespace App\Services\Susu\Requests\Susu;

use App\Services\Susu\SusuService;
use Domain\Customer\Models\Customer;
use Illuminate\Support\Facades\Http;

final class SusuWithScheme
{
    public SusuService $service;

    public function __construct()
    {
        $this->service = new SusuService;
    }

    public function execute(Customer $customer, string $susu_resource, string $scheme): array
    {
        // Set endpoint
        $endpoint = match (strtolower($scheme)) {
            'pss' => $this->service->base_url.'customers/'.$customer->resource_id.'/personal-susu/'.$susu_resource,
            'bss' => $this->service->base_url.'customers/'.$customer->resource_id.'/biz-susu/'.$susu_resource,
            'fss' => $this->service->base_url.'customers/'.$customer->resource_id.'/flexy-susu/'.$susu_resource,
        };

        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->get(
            url: $endpoint,
        )->json();
    }
}
