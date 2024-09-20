<?php

declare(strict_types=1);

namespace Domain\Shared\Action\General;

final class LinkGhanaCardValidationAction
{
    public static function isGhanaCardValid(string $user_input): bool
    {
        // Remove any non-alphanumeric characters like dashes or spaces
        $cardNumber = preg_replace(pattern: '/[^A-Za-z0-9]/', replacement: '', subject: $user_input);

        // Ensure the length is exactly 13 characters and match pattern
        return match (true) {
            strlen($cardNumber) !== 13 => false,
            ! str_starts_with($cardNumber, 'GHA') => false,
            ! ctype_digit(substr($cardNumber, offset: 3, length: 10)) => false,
            default => true,
        };
    }
}
