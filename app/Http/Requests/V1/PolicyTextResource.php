<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PolicyTextResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            // Resource type and id
            'type' => 'Policy',

            // Resource exposed attributes
            'attributes' => [
                'text' => $this->resource->text,
            ],
        ];
    }
}
