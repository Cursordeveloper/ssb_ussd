<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use App\Menus\Registration\RegistrationMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerUpdateFirstNameAction
{
    public static function execute(
         $customer, Request $request
    ): JsonResponse {
        // Validate the first_name input
        $validator = Validator::make($request->all(), ['Message' => ['required', 'alpha', 'between:2,20']]);

        // Terminate the session if validation failed
        if (!$validator->fails()) {
            // Update the customer record with the first_name
            $customer->update(['first_name' => data_get(target: $request, key: 'Message')]);

            // Return the last name prompt to the customer
            return RegistrationMenu::lastName(data_get(target: $request, key: 'SessionId'));
        }

        // Terminate the session
        return RegistrationMenu::invalidInput(data_get(target: $request, key: 'SessionId'));
    }
}
