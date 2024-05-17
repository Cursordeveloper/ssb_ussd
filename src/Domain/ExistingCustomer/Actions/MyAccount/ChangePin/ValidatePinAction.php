<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\ChangePin;

final class ValidatePinAction
{
    public static function execute($pin): bool
    {
        return is_numeric($pin) && strlen((string) $pin) === 4;
    }
}
