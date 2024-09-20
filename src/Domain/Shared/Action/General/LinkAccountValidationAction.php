<?php

declare(strict_types=1);

namespace Domain\Shared\Action\General;

final class LinkAccountValidationAction
{
    public static function isPhoneNumberLengthValid(string $user_input): bool
    {
        return ! (strlen($user_input) !== 10);
    }

    public static function isPhoneNumberValid(string $user_input): bool
    {
        return (bool) preg_match(pattern: '/^0[2-9]\d{8}$/', subject: $user_input);
    }
}
