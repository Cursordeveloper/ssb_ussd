<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Menus\Payment;

use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Payment\SusuPaymentMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentAmountMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Execute the SusuPaymentMenu and return the amountPaymentMenu JsonResponse
        return SusuPaymentMenu::amountPaymentMenu(session: $session);
    }
}
