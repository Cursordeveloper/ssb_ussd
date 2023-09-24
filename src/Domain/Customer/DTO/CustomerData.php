<?php

declare(strict_types=1);

namespace Domain\Customer\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

final class CustomerData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $resource_id,
        public ?string $first_name,
        public ?string $phone_number,
        public ?string $email,
        public ?string $status,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
    ) {
    }
}
