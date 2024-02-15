<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceClaims;

use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceClaimsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['content' => 0]);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://susubox.app/insurance/insurance-claims\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function nextContentMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "1. Insurance Claims: Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function invalidChoiceMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://susubox.app/insurance/insurance-claims\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }
}
