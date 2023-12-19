<?php

declare(strict_types=1);

namespace App\States\NewCustomer\Registration;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Customer\Actions\NewCustomer\Registration\CustomerCreateAction;
use Domain\Customer\Actions\NewCustomer\Registration\CustomerCreatePinAction;
use Domain\Customer\Actions\NewCustomer\Registration\CustomerUpdateFirstNameAction;
use Domain\Customer\Actions\NewCustomer\Registration\CustomerUpdateLastNameAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Create the customer if not existed
        if (! $customer) {
            // Create the customer with the phone number
            CustomerCreateAction::execute($session->phone_number);

            // Return the first name prompt to the customer
            return RegistrationMenu::firstName($session->session_id);
        }

        // Validate inputs and update the database
        return match (true) {
            data_get(target: $customer, key: 'first_name') === null => CustomerUpdateFirstNameAction::execute($customer, $session, $session_data),
            data_get(target: $customer, key: 'last_name') === null => CustomerUpdateLastNameAction::execute($customer, $session, $session_data),
            data_get(target: $customer, key: 'has_pin') === false => CustomerCreatePinAction::execute($customer, $session, $session_data),
            default => GeneralMenu::invalidInput($session),
        };
    }
}
