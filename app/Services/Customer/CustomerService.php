<?php

declare(strict_types=1);

namespace App\Services\Customer;

class CustomerService
{
    public string $base_url;

    public string $api_key;

    public function __construct()
    {
        $this->base_url = config(key: 'services.susubox.ssb_customer.base_url');
        $this->api_key = config(key: 'services.susubox.ssb_customer.api_key');
    }
}
