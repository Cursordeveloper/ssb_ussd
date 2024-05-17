<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Investment\InvestmentTerms;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentTermsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Investments\nFeatures coming soon.\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nFeatures coming soon.\n0. Back",
            session_id: $session->session_id,
        );
    }
}
