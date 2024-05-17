<?php

declare(strict_types=1);

namespace App\Services\Susu;

class SusuService
{
    public string $base_url;

    public string $api_key;

    public function __construct()
    {
        $this->base_url = config(key: 'services.susubox.ssb_susu.base_url');
        $this->api_key = config(key: 'services.susubox.ssb_susu.api_key');
    }
}
