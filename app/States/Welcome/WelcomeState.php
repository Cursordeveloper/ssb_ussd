<?php

namespace App\States\Welcome;

use App\Common\ResponseBuilder;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Action\CreateSessionAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WelcomeState
{
    public static function execute(
        array $request,
    ): JsonResponse {
        // Get the customer
        $customer = GetCustomerAction::execute(phone(data_get(target: $request, key: 'Mobile')));

        // Customer exist and status is active
        if (!$customer == null && data_get(target: $customer, key: 'status') === 'active') {
            // Create new session
            CreateSessionAction::execute(request: $request, action: 'CustomerState');

            // Return the registered customer menu
            return ResponseBuilder::ussdResourcesResponseBuilder(
                message: "Menu\n1. Some Menu 2\n2. Some Menu 2\n3. Some Menu 3\n4. My Account\n0. Exit",
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        }

        // Return the registration menu
        CreateSessionAction::execute(request: $request, action: 'NewCustomerState');
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Menu\n1. Register now\n2. Terms & Conditions\n0. Exit",
            session_id: data_get(target: $request, key: 'SessionId'),
        );
    }
}
