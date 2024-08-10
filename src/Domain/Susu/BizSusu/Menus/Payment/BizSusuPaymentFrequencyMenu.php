<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Menus\Payment;

use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Payment\SusuPaymentMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuPaymentFrequencyMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Execute the SusuPaymentMenu and return the frequencyFrequencyMenu JsonResponse
        return SusuPaymentMenu::frequencyFrequencyMenu(session: $session);
    }
}
