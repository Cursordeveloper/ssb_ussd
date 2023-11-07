<?php

namespace App\States;

use App\Common\ResponseBuilder;
use App\States\Welcome\WelcomeState;
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

        // Return a system failure message.
        return ResponseBuilder::invalidResponseBuilder(
            message: 'There was a problem with your request. Try again later.',
            session_id: data_get($request, key: 'SessionId'),
        );
    }
}
