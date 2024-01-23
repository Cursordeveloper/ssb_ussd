<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\AboutSusu;

use App\Menus\ExistingCustomer\Susu\AboutSusu\AboutSusuMenu;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BackToAboutSusuAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate inputs and update the session input
        $susu_state = ['class' => new AboutSusuState, 'menu' => new AboutSusuMenu];

        // Update the customer session action
        SessionUpdateAction::execute(session: $session, state: class_basename($susu_state['class']), session_data: $session_data);

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $susu_state['menu']::mainMenu(session: $session);
    }
}
