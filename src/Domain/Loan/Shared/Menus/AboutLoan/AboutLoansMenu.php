<?php

declare(strict_types=1);

namespace Domain\Loan\Shared\Menus\AboutLoan;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutLoansMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "About Loans\n1. Loan Schemes\n2. Qualification\n3. Application\n4. Collateral\n5. Disbursements\n6. Repayments\n7. Interests\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Loan Schemes\n2. Qualification\n3. Application\n4. Collateral\n5. Disbursements\n6. Repayments\n7. Interests\n0. Back",
            session_id: $session->session_id,
        );
    }
}
