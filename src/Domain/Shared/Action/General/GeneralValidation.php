<?php

declare(strict_types=1);

namespace Domain\Shared\Action\General;

final class GeneralValidation
{
    public static function pinLengthValid(string $user_input): bool
    {
        return ! (strlen($user_input) < 4);
    }
}
