<?php

namespace App\States\Customer;

use App\Common\ResponseBuilder;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Action\CreateSessionAction;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewCustomerState
{
    public static function execute(
        array $request,
    ): JsonResponse {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Enter First Name\n",
            session_id: data_get(target: $request, key: 'SessionId'),
        );
    }
}
