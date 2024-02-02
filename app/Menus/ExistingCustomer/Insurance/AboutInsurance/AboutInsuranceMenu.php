<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Insurance\AboutInsurance;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInsuranceMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "About Insurance\n1. Insurance Schemes\n2. Coverage & Benefits\n3. Premiums & Contributions\n4. Claims & Payouts\n5. Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Insurance Schemes\n2. Coverage & Benefits\n3. Premiums & Contributions\n4. Claims & Payouts\n5. Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }
}
