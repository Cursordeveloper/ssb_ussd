<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Pension\AboutPension;

use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionMenu;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BackToAboutPensionAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define the return state and menu
        $state = ['class' => new AboutPensionState, 'menu' => new AboutPensionMenu];

        // Update the customer session action
        UpdateSessionStateAction::execute(session: $session, state: class_basename($state['class']), session_data: $session_data);

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $state['menu']::mainMenu(session: $session);
    }
}
