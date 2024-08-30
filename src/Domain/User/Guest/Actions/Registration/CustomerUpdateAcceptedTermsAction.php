<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use Domain\Shared\Enums\Product\CustomerStatus;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Models\Customer;
use Domain\User\Guest\Jobs\Registration\CustomerRegistrationJob;
use Domain\User\Guest\Menus\Registration\RegistrationMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerUpdateAcceptedTermsAction
{
    public static function execute(Customer $customer, Session $session, $session_data): JsonResponse
    {
        // Register the customer if [accepted_terms]
        if ($session_data->user_input === '1') {
            // Update the customer accepted_terms
            $customer->update(['accepted_terms' => $session_data->user_input, 'status' => CustomerStatus::Active->value]);

            // Dispatch CustomerRegistrationJob
            CustomerRegistrationJob::dispatch($customer->refresh());

            // Return the enter pin prompt to the customer
            return RegistrationMenu::choosePin(session: $session);
        }

        // Terminate the session
        return GeneralMenu::invalidInput(session: $session);
    }
}
