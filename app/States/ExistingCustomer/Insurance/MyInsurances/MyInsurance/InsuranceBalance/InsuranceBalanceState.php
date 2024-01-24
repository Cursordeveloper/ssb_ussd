<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Insurance\MyInsurances\MyInsurance\InsuranceBalance;

use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceBalanceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return InsuranceMenu::mainMenu(session: $session);
    }
}
