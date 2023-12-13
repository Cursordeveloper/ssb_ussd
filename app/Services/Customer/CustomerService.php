<?php

declare(strict_types=1);

namespace App\Services\Customer;

use Domain\Customer\Models\Customer;
use Illuminate\Support\Facades\Http;

class CustomerService
{
    public string $base_url;

    public string $api_key;

    public function __construct()
    {
        $this->base_url = config(key: 'services.ssb_customer.base_url');
        $this->api_key = config(key: 'services.ssb_customer.api_key');
    }

    public function storeCustomer(array $data): void
    {
        Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->post(
            url: $this->base_url, data: $data
        )->json();
    }

    public function createPin(Customer $customer, $data): array
    {
        return Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ])->post(
            url: config(key: 'services.ssb_customer.base_url').'pin',
            data: ['data' => [
                'type' => 'Pin',
                'attributes' => [
                    'phone_number' => data_get(target: $customer, key: 'phone_number'),
                    'pin' => $data->user_input,
                ],
            ]],
        )->json();
    }

    public function linkNewAccount(Customer $customer, $data): array
    {
        return Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ])->post(
            url: config(key: 'services.ssb_customer.base_url').$customer->resource_id.'/linked-accounts',
            data: [
                'data' => [
                    'type' => 'LinkedAccount',
                    'attributes' => [
                        'account_number' => data_get(target: $data, key: 'phone_number'),
                    ],
                    'relationships' => [
                        'scheme' => [
                            'type' => 'Scheme',
                            'attributes' => [
                                'resource_id' => data_get(target: $data, key: 'network_resource'),
                            ],
                        ],
                    ],
                ],
            ],
        )->json();
    }

    public function linkNewAccountApproval(Customer $customer, $data): array
    {
        return Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ])->post(
            url: config(key: 'services.ssb_customer.base_url').$customer->resource_id.'/linked-accounts/approval',
            data: ['data' => [
                'type' => 'LinkedAccount',
                'attributes' => [
                    'account_number' => data_get(target: $data, key: 'phone_number'),
                    'pin' => data_get(target: $data, key: 'pin'),
                ],
            ]],
        )->json();
    }
}
