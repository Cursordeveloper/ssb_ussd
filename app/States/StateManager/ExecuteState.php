<?php

declare(strict_types=1);

namespace App\States\StateManager;

use App\Menus\Shared\GeneralMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ExecuteState
{
    public static function execute($customer_session, $session, $state_data): JsonResponse
    {
        // Get the StateClasses
        $states = StateClasses::execute();

        // Execute the state if it exists
        if (array_key_exists($customer_session, $states)) {
            return $states[$customer_session]::execute($session, $state_data);
        }

        // Return invalidInput (State does not exist)
        return GeneralMenu::invalidInput(session: $session);
    }
}
