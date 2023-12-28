<?php

declare(strict_types=1);

namespace App\States\NewCustomer\Registration;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Customer\Actions\NewCustomer\Registration\CustomerCreateAction;
use Domain\Customer\Actions\NewCustomer\Registration\RegistrationAction;
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

        return RegistrationAction::execute(customer: $customer, session: $session, session_data: $session_data);
    }
}
