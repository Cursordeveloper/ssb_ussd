<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\AboutSusu;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\AboutSusu\AboutSusuMenu;
use Domain\Susu\Shared\States\AboutSusu\AboutSusuState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BackToAboutSusuAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define the return state and menu
        $susu_state = ['class' => new AboutSusuState, 'menu' => new AboutSusuMenu];

        // Update the customer session action
        SessionStateUpdateAction::execute(session: $session, state: class_basename($susu_state['class']), service_data: $service_data);

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $susu_state['menu']::mainMenu(session: $session);
    }
}
