<?php

declare(strict_types=1);

namespace Domain\Loan\Shared\Menus\LoanBalance;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanBalanceMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Dear valued customer, features coming soon.',
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nDear valued customer, features coming soon.",
            session_id: $session->session_id,
        );
    }
}
