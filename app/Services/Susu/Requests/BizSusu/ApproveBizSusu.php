<?php

declare(strict_types=1);

namespace App\Services\Susu\Requests\BizSusu;

use App\Services\Susu\SusuService;
use Domain\Shared\Models\Customer\Customer;
use Illuminate\Support\Facades\Http;

final class ApproveBizSusu
{
    public SusuService $service;

    public function __construct()
    {
        $this->service = new SusuService;
    }

    public function approveBizSusu(Customer $customer, array $data, string $susu_resource): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->post(
            url: $this->service->base_url.'customers/'.$customer->resource_id.'/biz-susu/'.$susu_resource.'/approval',
            data: $data,
        )->json();
    }
}
