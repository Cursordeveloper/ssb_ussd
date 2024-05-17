<?php

declare(strict_types=1);

namespace Domain\Shared\Enums\Product;

enum CustomerStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Suspended = 'suspended';
    case Blocked = 'blocked';
}
