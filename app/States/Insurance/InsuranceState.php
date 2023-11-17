<?php

declare(strict_types=1);

namespace App\States\Insurance;

use App\Menus\Insurance\InsuranceMenu;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceState
{
    public static function execute(
        Session $session,
        Request $request,
    ): JsonResponse {
        // Pin validation

        // Create the expected input arrays
        $options = ['1', '2', '3', '0'];

        // Assign the customer input to a variable
        $customer_input = data_get(target: $request, key: 'Message');

        // Return the MyAccountMenu
        return InsuranceMenu::invalidMainMenu(session: $session);
    }
}
