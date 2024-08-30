<?php

declare(strict_types=1);

namespace App\Services\Susu\Requests\Susu;

use App\Common\Helpers;
use App\Services\Susu\SusuService;
use Domain\User\Customer\Models\Customer;
use Illuminate\Support\Facades\Http;

final class SusuServiceSusuRequest
{
    public SusuService $service;

    public function __construct()
    {
        $this->service = new SusuService;
    }

    public function execute(Customer $customer, string $susu_resource, string $scheme_code): array
    {
        // Get the susu_url
        $url = Helpers::getSusuScheme(scheme_code: $scheme_code);

        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
            ->get(url: $this->service->base_url.'customers/'.$customer->resource_id.'/'.data_get(target: $url, key: 'url').'/'.$susu_resource)
            ->json();
    }
}
