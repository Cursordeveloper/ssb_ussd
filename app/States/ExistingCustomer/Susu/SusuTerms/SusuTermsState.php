<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\SusuTerms;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuTermsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return GeneralMenu::infoNotification(
            session: $session,
            message: 'Dear valued customer, susu terms info coming soon.',
        );
    }
}
