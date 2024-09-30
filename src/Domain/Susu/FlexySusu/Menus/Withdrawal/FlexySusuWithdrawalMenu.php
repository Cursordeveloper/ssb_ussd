<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Menus\Withdrawal;

use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Withdrawal\SusuWithdrawalMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuWithdrawalMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Prepare and return the withdrawalMainMenu
        return SusuWithdrawalMenu::mainMenu(session: $session);
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        // Prepare and return the withdrawalMainMenu
        return SusuWithdrawalMenu::invalidMainMenu(session: $session);
    }
}
