<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Menus\Withdrawal;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuWithdrawalMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose payment type\n1. Withdraw own amount\n2. Full withdrawal",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Withdraw own amount\n2. Full withdrawal",
            session_id: $session->session_id,
        );
    }
}
