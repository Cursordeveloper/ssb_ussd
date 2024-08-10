<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Menus\Payment;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose payment type\n1. Pay in frequency\n2. Pay in amount\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Pay in frequency\n2. Pay in amount\n0. Back",
            session_id: $session->session_id,
        );
    }
}
