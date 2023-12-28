<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\NewCustomer\Registration;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Models\Customer;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationAction
{
    public static function execute(Customer $customer, $session, $session_data): JsonResponse
    {
        // Validate inputs and update the database
        return match (true) {
            data_get(target: $customer, key: 'first_name') === null => CustomerUpdateFirstNameAction::execute($customer, $session, $session_data),
            data_get(target: $customer, key: 'last_name') === null => CustomerUpdateLastNameAction::execute($customer, $session, $session_data),
            data_get(target: $customer, key: 'has_pin') === false => CustomerCreatePinAction::execute($customer, $session, $session_data),
            default => GeneralMenu::invalidInput($session),
        };
    }
}
