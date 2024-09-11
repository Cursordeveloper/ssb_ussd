<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Common;

use Domain\Insurance\Shared\Menus\Insurance\InsuranceMenu;
use Domain\Insurance\Shared\States\Insurance\InsuranceState;
use Domain\Investment\Shared\Menus\Investment\InvestmentMenu;
use Domain\Investment\Shared\States\Investment\InvestmentState;
use Domain\Loan\Shared\Menus\Loan\LoanMenu;
use Domain\Loan\Shared\States\Loan\LoanState;
use Domain\Pension\Shared\Menus\Pension\PensionMenu;
use Domain\Pension\Shared\States\Pension\PensionState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Susu\SusuMenu;
use Domain\Susu\Shared\States\Susu\SusuState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ReturnToServiceAction
{
    public static function execute(Session $session, $session_data, string $service): JsonResponse
    {
        // Define the return_state array
        $susubox_service = [
            'susu' => ['class' => new SusuState, 'menu' => new SusuMenu],
            'loan' => ['class' => new LoanState, 'menu' => new LoanMenu],
            'investment' => ['class' => new InvestmentState, 'menu' => new InvestmentMenu],
            'insurance' => ['class' => new InsuranceState, 'menu' => new InsuranceMenu],
            'pension' => ['class' => new PensionState, 'menu' => new PensionMenu],
        ];

        // Get the return service
        $return_state = $susubox_service[$service];

        // Update the customer session action
        SessionStateUpdateAction::execute(session: $session, state: class_basename($return_state['class']), session_data: $session_data);

        SessionInputUpdateAction::resetUserData(session: $session);
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $return_state['menu']::mainMenu(session: $session);
    }
}
