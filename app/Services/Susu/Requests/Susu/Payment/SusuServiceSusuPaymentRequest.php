<?php

declare(strict_types=1);

namespace App\Services\Susu\Requests\Susu\Payment;

use App\Services\Susu\Data\Susu\SusuPaymentData;
use App\Services\Susu\SusuService;
use Domain\Shared\Models\Customer\Customer;
use Illuminate\Support\Facades\Http;

final class SusuServiceSusuPaymentRequest
{
    public SusuService $service;

    public function __construct()
    {
        $this->service = new SusuService;
    }

    public function execute(Customer $customer, array $payment_data): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->post(
            url: $this->service->base_url.'customers/'.$customer->resource_id.'/susus/'.data_get(target: $payment_data, key: 'susu_account.resource_id').'/payments',
            data: $this->getData(payment_data: $payment_data),
        )->json();
    }

    private function getData(array $payment_data): array
    {
        return SusuPaymentData::toArray(payment_data: $payment_data);
    }
}
