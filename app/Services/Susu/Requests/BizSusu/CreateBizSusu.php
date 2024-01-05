<?php

declare(strict_types=1);

namespace App\Services\Susu\Requests\BizSusu;

use App\Services\Susu\SusuService;
use Domain\Customer\Models\Customer;
use Illuminate\Support\Facades\Http;

final class CreateBizSusu
{
    public SusuService $service;

    public function __construct()
    {
        $this->service = new SusuService;
    }

    public function createBizSusu(Customer $customer, array $data): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->post(
            url: $this->service->base_url.'customers/'.$customer->resource_id.'/biz-susu',
            data: $data,
        )->json();
    }
}
