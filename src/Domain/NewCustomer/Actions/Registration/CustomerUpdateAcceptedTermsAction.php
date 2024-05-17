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

final class CustomerUpdateAcceptedTermsAction
{
    public static function execute(Customer $customer, Session $session, $session_data): JsonResponse
    {
        // Register the customer if [accepted_terms]
        if ($session_data->user_input === '1') {
            // Update the customer accepted_terms
            $customer->update(['accepted_terms' => $session_data->user_input, 'status' => CustomerStatus::Active->value]);

            // Dispatch CustomerCreatedEvent
            CustomerCreatedEvent::dispatch($customer->refresh());

            // Return the enter pin prompt to the customer
            return RegistrationMenu::choosePin(session: $session);
        }

        // Terminate the session
        return GeneralMenu::invalidInput(session: $session);
    }
}
