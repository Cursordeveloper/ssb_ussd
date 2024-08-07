<?php

declare(strict_types=1);

namespace App\Services\Susu\Requests\PersonalSusu\Pause;

use App\Services\Susu\SusuService;
use Domain\Shared\Models\Customer\Customer;
use Illuminate\Support\Facades\Http;

final class SusuServicePersonalSusuCollectionPauseApprovalRequest
{
    public SusuService $service;

    public function __construct()
    {
        $this->service = new SusuService;
    }

    public function execute(Customer $customer, array $data, string $susu_resource, string $pause_resource): array
    {
        return Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json'])
            ->post(url: $this->service->base_url.'customers/'.$customer->resource_id.'/personal-susus/'.$susu_resource.'/collections/'.$pause_resource.'/approvals', data: $data)
            ->json();
    }
}
