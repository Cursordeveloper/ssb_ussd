<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use App\Menus\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\Pin\CreatePinAction;
use Domain\Customer\Models\Customer;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerCreatePinAction
{
    public static function execute(
        Customer $customer,
        Session $session,
        $session_data,
    ): JsonResponse {
        // Terminate the session if validation failed
        if (is_numeric($session_data->user_input) && strlen((string)$session_data->user_input) == 4) {
            // Create the customer pin
            $pin_created = CreatePinAction::execute($customer, $session_data);

            // Update the customer pin and status
            if (data_get($pin_created, key: 'status') === true) {
                // Update the customer table
                $customer->update(['has_pin' => true]);

                // Return registrations success
                return RegistrationMenu::successResponse(data_get(target: $session, key: 'session_id'));
            }

            // Return registrations success
            return GeneralMenu::infoNotification(message: 'Pin creation failed. Try again later', session: $session);
        }

        // Terminate the session
        return GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id'));
    }
}
