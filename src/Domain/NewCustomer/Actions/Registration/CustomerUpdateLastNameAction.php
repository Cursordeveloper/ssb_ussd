<?php

declare(strict_types=1);

namespace Domain\NewCustomer\Actions\Registration;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\NewCustomer\Events\Registration\CustomerCreatedEvent;
use Domain\Shared\Enums\Product\CustomerStatus;
use Domain\Shared\Models\Customer\Customer;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerUpdateLastNameAction
{
    public static function execute(Customer $customer, Session $session, $session_data): JsonResponse
    {
        // Terminate the session if validation failed
        if (preg_match(pattern: "/^([a-zA-Z' ]+)$/", subject: $session_data->user_input) && $session_data->user_input > 1) {
            // Update the customer record with the last_name
            $customer->update(['last_name' => $session_data->user_input, 'status' => CustomerStatus::Active->value]);

            // Dispatch CustomerCreatedEvent
            CustomerCreatedEvent::dispatch($customer->refresh());

            // Return the last name prompt to the customer
            return RegistrationMenu::choosePin(data_get(target: $session, key: 'session_id'));
        }

        // Terminate the session
        return GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id'));
    }
}
