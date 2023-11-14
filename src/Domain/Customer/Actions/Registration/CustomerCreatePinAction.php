<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use App\Menus\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Enums\CustomerStatus;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerCreatePinAction
{
    public static function execute(
        $customer,
        Session $session,
        Request $request
    ): JsonResponse {
        // Validate the pin
        $validator = Validator::make($request->all(), ['Message' => ['numeric', 'digits:4']]);

        // Terminate the session if validation failed
        if (! $validator->fails()) {
            // Update the customer pin and status
            $customer->update(['has_pin' => true, 'status' => CustomerStatus::Active->value]);

            // Return registrations success
            return RegistrationMenu::successResponse(data_get(target: $session, key: 'session_id'));
        }

        // Terminate the session
        return GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id'));
    }
}
