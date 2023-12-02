<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Pin;

use Domain\Customer\Models\Customer;
use Illuminate\Support\Facades\Http;

final class CreatePinAction
{
    public static function execute(
        Customer $customer,
        $session_data,
    ): array {
        return Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ])->post(
            url: config(key: 'services.ssb_customer.base_url').'pin',
            data: [
                'data' => [
                    'type' => 'Pin',
                    'attributes' => [
                        'phone_number' => data_get(target: $customer, key: 'phone_number'),
                        'pin' => $session_data->user_input,
                    ],
                ],
            ],
        )->json();
    }
}
