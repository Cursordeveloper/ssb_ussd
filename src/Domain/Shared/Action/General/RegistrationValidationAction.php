<?php

declare(strict_types=1);

namespace Domain\Shared\Action\General;

final class RegistrationValidationAction
{
    public static function isNameLengthValid(string $user_input): bool
    {
        return ! (strlen($user_input) > 25);
    }

    public static function isNameStringValid(string $user_input): bool
    {
        return (bool) preg_match(pattern: "/^([a-zA-Z'.-]+)$/", subject: $user_input);
    }

    public static function isNumericValid(string $user_input): bool
    {
        return is_numeric($user_input);
    }

    public static function isPinLengthValid(string $user_input): bool
    {
        return ! (strlen($user_input) !== 4);
    }
}
