<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans;

use App\Menus\ExistingCustomer\Loan\LoanMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Pin validation

        // Create the expected input arrays
        //        $options = ['1', '2', '3', '0'];

        // Assign the customer input to a variable
        //        $customer_input = $session_data->user_input;

        // Return the MyAccountMenu
        return LoanMenu::invalidMainMenu(session: $session);
    }
}
