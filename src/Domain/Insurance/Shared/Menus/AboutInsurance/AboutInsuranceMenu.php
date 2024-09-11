<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\Menus\AboutInsurance;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInsuranceMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "About Insurance\n1. Insurance Schemes\n2. Coverage\n3. Premiums\n4. Contributions\n5. Claims \n6. Payouts\n7. Commissions\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Insurance Schemes\n2. Coverage\n3. Premiums\n4. Contributions\n5. Claims \n6. Payouts\n7. Commissions\n0. Back",
            session_id: $session->session_id,
        );
    }
}
