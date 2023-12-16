<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Models\Customer;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerUpdateFirstNameAction
{
    public static function execute(
        Customer $customer,
        Session $session,
        $session_data
    ): JsonResponse {
        // Terminate the session if validation failed
        if (preg_match(pattern: "/^([a-zA-Z' ]+)$/", subject: $session_data->user_input) && $session_data->user_input > 1) {
            // Update the customer record with the first_name
            $customer->update(['first_name' => $session_data->user_input]);

            // Return the last name prompt to the customer
            return RegistrationMenu::lastName(data_get(target: $session, key: 'session_id'));
        }

        // Terminate the session
        return GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id'));
    }
}
