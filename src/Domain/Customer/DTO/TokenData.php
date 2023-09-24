<?php

declare(strict_types=1);

namespace Domain\Customer\DTO;

use Spatie\LaravelData\Data;

final class TokenData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $customer_id,
        public readonly ?int $token,
        public readonly ?string $token_expiration_date,
        public readonly ?bool $is_verified,
    ) {
    }
}
