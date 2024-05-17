<?php

declare(strict_types=1);

namespace App\Services\Mobile\Requests;

use App\Services\Mobile\MobileService;
use Illuminate\Support\Facades\Http;

final class MobileServiceCustomerCreateRequest
{
    public MobileService $service;

    public function __construct()
    {
        $this->service = new MobileService;
    }

    public function execute(array $data): void
    {
        Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])->post(
            url: $this->service->base_url.'customers',
            data: $data
        )->json();
    }
}
