<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\SusuPayment;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuPaymentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the MyAccountMenu
        return GeneralMenu::infoNotification(
            session: $session,
            message: 'Dear valued customer, manual payment features coming soon.',
        );
    }
}
