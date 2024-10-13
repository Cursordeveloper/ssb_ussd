<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\TermsAndConditions;

use App\Common\PolicyText;
use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Update the user_inputs (page)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['page' => 0]);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: PolicyText::getPolicyUrl(policy: 'terms-and-conditions')."\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function invalidInputMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }
}
