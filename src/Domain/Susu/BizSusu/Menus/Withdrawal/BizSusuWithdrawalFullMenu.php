<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Menus\Withdrawal;

use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\SusuWithdrawalMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuWithdrawalFullMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Prepare and return the withdrawalConfirmationMenu
        return SusuWithdrawalMenu::fullWithdrawalConfirmationMenu(session: $session);
    }
}
