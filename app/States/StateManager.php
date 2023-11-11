<?php

declare(strict_types=1);

namespace App\States;

use App\Common\ResponseBuilder;
use App\States\Customer\NewCustomerState;
use App\States\Registration\RegistrationState;
use App\States\TermsAndConditions\TermsAndConditionsState;
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
        } elseif (strtolower(data_get(target: $request, key: 'Type')) === 'initiation' && data_get(target: $request, key: 'Message') === "0") {
            return ResponseBuilder::terminateResponseBuilder(
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        }

        $states = [
            'NewCustomerState' => new NewCustomerState,
            'RegistrationState' => new RegistrationState,
            'TermsAndConditionsState' => new TermsAndConditionsState,
        ];

        // Get the session
        $session = GetSessionAction::execute(session_id: data_get(target: $request, key: 'SessionId'));
        $customer_session = data_get(target: $session, key: 'state');

        if (array_key_exists($customer_session, $states)) {
            $customer_state = $states[$customer_session];

            return $customer_state::execute($request);
        }

        // Return a system failure message.
        return ResponseBuilder::invalidResponseBuilder(
            message: 'There was a problem with your request. Try again later.',
            session_id: data_get($request, key: 'SessionId'),
        );
    }
}
