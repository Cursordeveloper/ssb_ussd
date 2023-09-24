<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Authentication;

final class LogoutAction
{
    public static function execute(): bool
    {
        auth()->guard(
            name: 'customer'
        )->logout();
        return true;
    }
}
