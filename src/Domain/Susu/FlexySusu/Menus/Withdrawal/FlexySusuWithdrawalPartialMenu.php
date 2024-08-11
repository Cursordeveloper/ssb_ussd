<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Menus\Withdrawal;

use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Withdrawal\SusuWithdrawalMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuWithdrawalPartialMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return SusuWithdrawalMenu::withdrawalAmountMenu(session: $session);
    }
}
