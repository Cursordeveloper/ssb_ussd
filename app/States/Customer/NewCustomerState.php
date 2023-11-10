<?php

namespace App\States\Customer;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewCustomerState
{
    public static function execute(
        array $request,
    ): JsonResponse {
        // Create the expected input arrays
        $options = ['1', '2'];

        // Check if use input is in the array
        if (in_array(data_get(target: $request, key: 'Message'), haystack: $options)) {
            return ResponseBuilder::ussdResourcesResponseBuilder(
                message: "Enter First Name\n",
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        }

        // The customer input is invalid
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input. Try again\n1 Menu\n1. Register now\n2. Terms & Conditions\n0. Exit",
            session_id: data_get(target: $request, key: 'SessionId'),
        );
    }
}
