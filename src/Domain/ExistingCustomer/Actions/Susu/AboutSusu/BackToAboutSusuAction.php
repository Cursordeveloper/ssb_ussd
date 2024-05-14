<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\AboutSusu;

use App\Menus\ExistingCustomer\Susu\AboutSusu\AboutSusuMenu;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BackToAboutSusuAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define the return state and menu
        $susu_state = ['class' => new AboutSusuState, 'menu' => new AboutSusuMenu];

        // Update the customer session action
        UpdateSessionStateAction::execute(session: $session, state: class_basename($susu_state['class']), session_data: $session_data);

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $susu_state['menu']::mainMenu(session: $session);
    }
}
