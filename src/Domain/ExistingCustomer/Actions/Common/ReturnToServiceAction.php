<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Common;

use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use App\Menus\ExistingCustomer\Investment\InvestmentMenu;
use App\Menus\ExistingCustomer\Loan\LoanMenu;
use App\Menus\ExistingCustomer\Pension\PensionMenu;
use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\Insurance\InsuranceState;
use App\States\ExistingCustomer\Investments\InvestmentState;
use App\States\ExistingCustomer\Loans\LoanState;
use App\States\ExistingCustomer\Pension\PensionState;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
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
        UpdateSessionStateAction::execute(session: $session, state: class_basename($return_state['class']), session_data: $session_data);

        SessionInputUpdateAction::resetUserData(session: $session);
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return to the SusuState
        return $return_state['menu']::mainMenu(session: $session);
    }
}
