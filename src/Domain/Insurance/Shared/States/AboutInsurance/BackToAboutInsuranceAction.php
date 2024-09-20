<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\States\AboutInsurance;

use Domain\Insurance\Shared\Menus\AboutInsurance\AboutInsuranceMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BackToAboutInsuranceAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define the return state and menu
        $state = ['class' => new AboutInsuranceState, 'menu' => new AboutInsuranceMenu];

        // Update the customer session action
        SessionStateUpdateAction::execute(session: $session, state: class_basename($state['class']), service_data: $service_data);

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $state['menu']::mainMenu(session: $session);
    }
}
