<?php

declare(strict_types=1);

namespace App\States\Registration;

use App\Common\ResponseBuilder;
use Domain\Customer\Actions\Registration\CreateCustomerAction;
use Domain\Customer\Models\Customer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Validator;

final class RegistrationState
{
    public static function execute(
        Request $request,
    ): JsonResponse {
        // Get customer phone
        $phone_number = phone(data_get(target: $request, key: 'Mobile'));

        // Get the customer
        $customer = Customer::query()->where(column: 'phone_number', operator: '=', value: $phone_number)->first();

        // Create the customer if not existed
        if (!$customer) {
            // Create the customer with the phone number
            CreateCustomerAction::execute($phone_number);

            // Return the first name prompt to the customer
            return ResponseBuilder::ussdResourcesResponseBuilder(
                message: 'Enter your first name.',
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        } elseif (data_get(target: $customer, key: 'first_name') === null) {
            // Validate and update first_name
            if (preg_match(pattern: '/^[a-zA-Z]+$/', subject: data_get(target: $request, key: 'Message'))) {
                // Update the customer record with the first_name
                $customer->update(['first_name' => data_get(target: $request, key: 'Message')]);

                // Return the last name prompt to the customer
                return ResponseBuilder::ussdResourcesResponseBuilder(
                    message: 'Enter your last name.',
                    session_id: data_get(target: $request, key: 'SessionId'),
                );
            }

            // Terminate the session if update customer failed
            return ResponseBuilder::invalidResponseBuilder(
                message: 'There was a problem with your request. Try again later.',
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        } elseif (data_get(target: $customer, key: 'last_name') === null) {
            if (preg_match(pattern: '/^[a-zA-Z]+$/', subject: data_get(target: $request, key: 'Message'))) {
                // Update the customer record with the first_name
                $customer->update(['last_name' => data_get(target: $request, key: 'Message')]);

                // Dispatch customer created job to the ssb_customer api

                // Return the last name prompt to the customer
                return ResponseBuilder::ussdResourcesResponseBuilder(
                    message: 'Enter your pin 4 digit ssb pin.',
                    session_id: data_get(target: $request, key: 'SessionId'),
                );
            }

            // Terminate the session if update customer failed
            return ResponseBuilder::invalidResponseBuilder(
                message: 'There was a problem with your request. Try again later.',
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        } elseif (data_get(target: $customer, key: 'has_pin') === false) {
            // Validate the pin
            $validator = Validator::make($request->all(), ['Message' => ['numeric', 'digits:4']]);

            // Check if validation fails
            if (!$validator->fails()) {
                // Dispatch customer created job to the ssb_customer api

                $customer->update(['has_pin' => true, 'status' => 'active']);

                // Return registrations success
                return ResponseBuilder::invalidResponseBuilder(
                    message: 'Congratulations! Registration successful.',
                    session_id: data_get(target: $request, key: 'SessionId'),
                );
            }

            // Return the last name prompt to the customer
            return ResponseBuilder::invalidResponseBuilder(
                message: 'There was a problem with your request. Try again later.',
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        }

        return ResponseBuilder::invalidResponseBuilder(
            message: 'There was a problem with your request. Try again later.',
            session_id: data_get(target: $request, key: 'SessionId'),
        );
    }
}
