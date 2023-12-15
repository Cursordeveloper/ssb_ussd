<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments;

use App\Menus\Investment\InvestmentsMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Pin validation

        // Create the expected input arrays
        $options = ['1', '2', '3', '0'];

        // Assign the customer input to a variable
        $customer_input = $session_data->user_input;

        // Return the MyAccountMenu
        return InvestmentsMenu::invalidMainMenu(session: $session);
    }
}
