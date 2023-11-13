<?php

declare(strict_types=1);

namespace App\States\Registration;

use App\Menus\Registration\RegistrationMenu;
use Domain\Customer\Actions\Registration\CustomerCreateAction;
use Domain\Customer\Actions\Registration\CustomerCreatePinAction;
use Domain\Customer\Actions\Registration\CustomerUpdateFirstNameAction;
use Domain\Customer\Actions\Registration\CustomerUpdateLastNameAction;
use Domain\Customer\Models\Customer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationState
{
    public static function execute(Request $request): JsonResponse {
        // Get customer phone
        $phone_number = phone(data_get(target: $request, key: 'Mobile'));

        // Get the customer
        $customer = Customer::query()->where(column: 'phone_number', operator: '=', value: $phone_number)->first();

        // Create the customer if not existed
        if (!$customer) {
            // Create the customer with the phone number
            CustomerCreateAction::execute($phone_number);

            // Return the first name prompt to the customer
            return RegistrationMenu::firstName(data_get(target: $request, key: 'SessionId'));
        }

        // Validate the customer first_name input and update database
        if (data_get(target: $customer, key: 'first_name') === null) {
            return CustomerUpdateFirstNameAction::execute(customer: $customer, request: $request);
        }

        // Validate the customer last_name input and update database
        if (data_get(target: $customer, key: 'last_name') === null) {
            return CustomerUpdateLastNameAction::execute(customer: $customer, request: $request);
        }

        // Validate the customer pin input and update database
        if (data_get(target: $customer, key: 'has_pin') === false) {
            return CustomerCreatePinAction::execute(customer: $customer, request: $request);
        }

        // Terminate the session
        return RegistrationMenu::invalidInput(data_get(target: $request, key: 'SessionId'));
    }
}
