<?php

namespace App\States;

use App\Common\ResponseBuilder;
use App\States\Customer\NewCustomerState;
use App\States\Welcome\WelcomeState;
use Domain\Shared\Action\GetSessionAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StateManager
{
    public static function execute(
        array $request
    ): JsonResponse {
        // Check if the type is "initiation"
        if (strtolower(data_get(target: $request, key: 'Type')) === 'initiation') {
            return WelcomeState::execute($request);
        }

        // If the user entered 0, then exit the application
        if (data_get(target: $request, key: 'Message') === "0") {
            return ResponseBuilder::terminateResponseBuilder(
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        }

        // Get the session
        $session = GetSessionAction::execute(
            session_id: data_get(
                target: $request,
                key: 'SessionId',
            ),
        );

        if (!$session == null) {
            return NewCustomerState::execute(
                request: $request,
            );
        }

        // Return a system failure message.
        return ResponseBuilder::invalidResponseBuilder(
            message: 'There was a problem with your request. Try again later.',
            session_id: data_get($request, key: 'SessionId'),
        );
    }
}
