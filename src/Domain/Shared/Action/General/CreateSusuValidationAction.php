<?php

declare(strict_types=1);

namespace Domain\Shared\Action\General;

final class CreateSusuValidationAction
{
    public static function accountNameLength(string $user_input): bool
    {
        return ! (strlen($user_input) > 20);
    }

    public static function amountValid(string $user_input): bool
    {
        return ! ((float) $user_input < 5);
    }

    public static function startWithInteger(string $user_input): bool
    {
        if (is_numeric($user_input)) {
            return true;
        }
        return false;
    }

    public static function startWithTotal(string $user_input): bool
    {
        return ! ((int) $user_input > 5);
    }
}
