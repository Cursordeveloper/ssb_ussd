<?php

declare(strict_types=1);

namespace Domain\Pension\Shared\Actions\AboutPension;

use Domain\Pension\Shared\Menus\AboutPension\AboutPensionMenu;
use Domain\Pension\Shared\States\AboutPension\AboutPensionState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BackToAboutPensionAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define the return state and menu
        $state = ['class' => new AboutPensionState, 'menu' => new AboutPensionMenu];

        // Update the customer session action
        SessionStateUpdateAction::execute(session: $session, state: class_basename($state['class']), session_data: $session_data);

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $state['menu']::mainMenu(session: $session);
    }
}
