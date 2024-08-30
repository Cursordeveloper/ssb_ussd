<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Models\Customer;
use Domain\User\Guest\Menus\Registration\RegistrationMenu;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerCreateAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Terminate the session if validation failed
        if (preg_match(pattern: "/^([a-zA-Z' ]+)$/", subject: $session_data->user_input) && $session_data->user_input > 1) {
            // Create the Customer
            Customer::query()->create(['resource_id' => Str::uuid()->toString(), 'phone_number' => $session->phone_number, 'first_name' => $session_data->user_input]);

            // Return the last name prompt to the customer
            return RegistrationMenu::lastName(session: $session);
        }

        // Terminate the session
        return GeneralMenu::invalidInput(session: $session);
    }
}
