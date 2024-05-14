<?php

declare(strict_types=1);

namespace App\States\NewCustomer\Registration;

use App\Menus\Shared\GeneralMenu;
use Domain\NewCustomer\Actions\Registration\CustomerCreateAction;
use Domain\NewCustomer\Actions\Registration\CustomerCreatePinAction;
use Domain\NewCustomer\Actions\Registration\CustomerUpdateAcceptedTermsAction;
use Domain\NewCustomer\Actions\Registration\CustomerUpdateLastNameAction;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Create the customer if not existed
        if (! $customer) {
            return CustomerCreateAction::execute(session: $session, session_data: $session_data);
        }

        // Validate inputs and update the database
        return match (true) {
            $customer->last_name === null => CustomerUpdateLastNameAction::execute($customer, $session, $session_data),
            $customer->accepted_terms === false => CustomerUpdateAcceptedTermsAction::execute($customer, $session, $session_data),
            $customer->has_pin === false => CustomerCreatePinAction::execute($customer, $session, $session_data),
            default => GeneralMenu::invalidInput($session),
        };
    }
}
