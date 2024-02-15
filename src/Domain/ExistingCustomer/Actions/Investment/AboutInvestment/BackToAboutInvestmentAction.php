<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Investment\AboutInvestment;

use App\Menus\ExistingCustomer\Investment\AboutInvestment\AboutInvestmentMenu;
use App\States\ExistingCustomer\Investments\AboutInvestment\AboutInvestmentState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BackToAboutInvestmentAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define the return state and menu
        $susu_state = ['class' => new AboutInvestmentState, 'menu' => new AboutInvestmentMenu];

        // Update the customer session action
        SessionUpdateAction::execute(session: $session, state: class_basename($susu_state['class']), session_data: $session_data);

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $susu_state['menu']::mainMenu(session: $session);
    }
}
