<?php

declare(strict_types=1);

namespace App\Services\Susu;

use Domain\Customer\Models\Customer;
use Illuminate\Support\Facades\Http;

class SusuService
{
    public string $base_url;

    public string $api_key;

    public function __construct()
    {
        $this->base_url = config(key: 'services.susubox.ssb_susu.base_url');
        $this->api_key = config(key: 'services.susubox.ssb_susu.api_key');
    }

    public function createPersonalSusu(Customer $customer, array $data): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->post(
            url: config(key: 'services.susubox.ssb_susu.base_url').'customers/'.$customer->resource_id.'/personal',
            data: $data,
        )->json();
    }

    public function personalSusuApproval(Customer $customer, array $data, string $susu_resource): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->post(
            url: config(key: 'services.susubox.ssb_susu.base_url').'customers/'.$customer->resource_id.'/personal/'.$susu_resource.'/approval',
            data: $data,
        )->json();
    }

    public function getSusuCollection(Customer $customer): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->get(
            url: config(key: 'services.susubox.ssb_susu.base_url').'customers/'.$customer->resource_id.'/accounts',
        )->json();
    }
}
