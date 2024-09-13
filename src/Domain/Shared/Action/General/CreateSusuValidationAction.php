<?php

declare(strict_types=1);

namespace Domain\Shared\Action\General;

final class CreateSusuValidationAction
{
    public static function accountNameLengthValid(string $user_input): bool
    {
        return ! (strlen($user_input) > 20);
    }

    public static function susuAmountValid(string $user_input): bool
    {
        return ! ((float) $user_input < 5);
    }

    public static function targetAmountValid(string $user_input): bool
    {
        return ! ((float) $user_input < 500);
    }

    public static function initialDepositAmountValid(string $user_input): bool
    {
        return ! ((float) $user_input < 5);
    }

    public static function isNumericValid(string $user_input): bool
    {
        return is_numeric($user_input);
    }

    public static function startWithTotalValid(string $user_input): bool
    {
        return ! ((int) $user_input > 5);
    }
}
