<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\MyAccount\ChangePin;

final class ValidatePinAction
{
    public static function execute($pin): bool
    {
        return is_numeric($pin) && strlen((string) $pin) === 4;
    }
}
