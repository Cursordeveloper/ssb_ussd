<?php

declare(strict_types=1);

namespace App\States\Registration;

use App\Menus\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Customer\Actions\Registration\CustomerCreateAction;
use Domain\Customer\Actions\Registration\CustomerCreatePinAction;
use Domain\Customer\Actions\Registration\CustomerUpdateFirstNameAction;
use Domain\Customer\Actions\Registration\CustomerUpdateLastNameAction;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationState
{
    public static function execute(
        Session $session,
        Request $request,
    ): JsonResponse {
        // Get the customer
        $customer = GetCustomerAction::execute(data_get(target: $session, key: 'phone_number'));

        // Create the customer if not existed
        if (! $customer) {
            // Create the customer with the phone number
            CustomerCreateAction::execute(data_get(target: $session, key: 'phone_number'));

            // Return the first name prompt to the customer
            return RegistrationMenu::firstName(data_get(target: $session, key: 'session_id'));
        }

        // Validate inputs and update the database
        return match (true) {
            data_get(target: $customer, key: 'first_name') === null =>
            CustomerUpdateFirstNameAction::execute(customer: $customer, session: $session, request: $request),

            data_get(target: $customer, key: 'last_name') === null =>
            CustomerUpdateLastNameAction::execute(customer: $customer, session: $session, request: $request),

            data_get(target: $customer, key: 'has_pin') === false =>
            CustomerCreatePinAction::execute(customer: $customer, session: $session, request: $request),

            default => GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id')),
        };
    }
}
