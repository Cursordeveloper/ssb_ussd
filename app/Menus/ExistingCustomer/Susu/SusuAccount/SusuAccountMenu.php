<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\SusuAccount;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountMenu
{
    public static function mainMenu($session, $session_data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You do not have any active susu account.\n0. Back",
            session_id: $session->session_id,
        );
    }
}
