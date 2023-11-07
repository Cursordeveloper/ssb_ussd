<?php

namespace App\States\Welcome;

use App\Common\ResponseBuilder;
use Domain\Customer\Actions\Common\GetCustomerAction;
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
            return ResponseBuilder::ussdResourcesResponseBuilder(
                message: "Welcome Back\n1). Some Menu 2\n2). Some Menu 2\n3) Some Menu 3",
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        }

        // Return the registration menu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Welcome! Ssb\n1). Register now\n2). Terms & Conditions\n0) Exit",
            session_id: data_get(target: $request, key: 'SessionId'),
        );
    }
}
