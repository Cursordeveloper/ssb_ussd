<?php

declare(strict_types=1);

namespace App\Services\Susu\Requests\BizSusu\Payment;

use App\Services\Susu\SusuService;
use Domain\Shared\Models\Customer\Customer;
use Illuminate\Support\Facades\Http;

final class SusuServiceBizSusuPaymentFrequencyRequest
{
    public SusuService $service;

    public function __construct()
    {
        $this->service = new SusuService;
    }

    public function execute(Customer $customer, array $data, string $susu_resource): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
            ->post(url: $this->service->base_url.'customers/'.$customer->resource_id.'/biz-susus/'.$susu_resource.'/payments', data: $data)
            ->json();
    }
}
