<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\MyInsuranceAccounts;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyInsuranceAccountsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You do not have any active insurance(s).\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nYou do not have any active insurance(s).\n0. Back",
            session_id: $session->session_id,
        );
    }
}
