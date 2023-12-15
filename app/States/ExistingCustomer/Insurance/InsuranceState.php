<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Insurance;

use App\Menus\Insurance\InsuranceMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Pin validation

        // Create the expected input arrays
        $options = ['1', '2', '3', '0'];

        // Assign the customer input to a variable
        $customer_input = $session_data->user_input;

        // Return the MyAccountMenu
        return InsuranceMenu::invalidMainMenu(session: $session);
    }
}
