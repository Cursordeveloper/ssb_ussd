<?php

declare(strict_types=1);

namespace App\States\Susu;

use App\Menus\Shared\GeneralMenu;
use App\Menus\Susu\SusuSavingsMenu;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuSavingsState
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
        return SusuSavingsMenu::invalidMainMenu(session: $session);
    }
}
