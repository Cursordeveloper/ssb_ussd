<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Menus\Withdrawal;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuWithdrawalMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Return the account main menu
        return ResponseBuilder::infoResponseBuilder(
            message: 'Account liquidation features coming soon',
            session_id: $session->session_id,
        );
    }
}
