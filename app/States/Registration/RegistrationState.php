<?php

declare(strict_types=1);

namespace App\States\Registration;

use App\Menus\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\Registration\CustomerCreateAction;
use Domain\Customer\Actions\Registration\CustomerCreatePinAction;
use Domain\Customer\Actions\Registration\CustomerUpdateFirstNameAction;
use Domain\Customer\Actions\Registration\CustomerUpdateLastNameAction;
use Domain\Customer\Models\Customer;
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
        $customer = Customer::query()->where(column: 'phone_number', operator: '=', value: data_get(target: $session, key: 'phone_number'))->first();

        // Create the customer if not existed
        if (! $customer) {
            // Create the customer with the phone number
            CustomerCreateAction::execute(data_get(target: $session, key: 'phone_number'));

            // Return the first name prompt to the customer
            return RegistrationMenu::firstName(data_get(target: $session, key: 'session_id'));
        }

        // Validate the customer first_name input and update database
        if (data_get(target: $customer, key: 'first_name') === null) {
            return CustomerUpdateFirstNameAction::execute(
                customer: $customer,
                session: $session,
                request: $request,
            );
        }

        // Validate the customer last_name input and update database
        if (data_get(target: $customer, key: 'last_name') === null) {
            return CustomerUpdateLastNameAction::execute(
                customer: $customer,
                session: $session,
                request: $request,
            );
        }

        // Validate the customer pin input and update database
        if (data_get(target: $customer, key: 'has_pin') === false) {
            return CustomerCreatePinAction::execute(
                customer: $customer,
                session: $session,
                request: $request,
            );
        }

        // Terminate the session
        return GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id'));
    }
}
