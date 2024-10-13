<?php

declare(strict_types=1);

namespace Domain\Shared\States\TermsAndConditions;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\TermsAndConditions\TermsAndConditionsMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\Welcome\WelcomeState;
use Domain\User\Guest\Actions\TermsAndConditions\TermsAndConditionsAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            $service_data->user_input === '#' => TermsAndConditionsAction::execute(session: $session, service_data: $service_data),
            $service_data->user_input === '0' => self::exitExecution(session: $session),

            default => TermsAndConditionsMenu::invalidInputMenu($session),
        };
    }

    private static function exitExecution(Session $session): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return the WelcomeState
        return WelcomeState::execute(session: $session);
    }
}
