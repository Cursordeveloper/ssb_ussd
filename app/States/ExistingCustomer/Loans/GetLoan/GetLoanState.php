<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans\GetLoan;

use App\Menus\ExistingCustomer\Loan\GetLoan\BizSusuLoan\BizSusuLoanMenu;
use App\Menus\ExistingCustomer\Loan\GetLoan\GetLoanMenu;
use App\Menus\ExistingCustomer\Loan\GetLoan\PersonalSusuLoan\PersonalSusuLoanMenu;
use App\Menus\ExistingCustomer\Loan\GetLoan\SwiftCredit\SwiftCreditMenu;
use App\Menus\ExistingCustomer\MyAccount\LinkKyc\LinkKycMenu;
use App\States\ExistingCustomer\Loans\GetLoan\BizSusuLoan\BizSusuLoanState;
use App\States\ExistingCustomer\Loans\GetLoan\PersonalSusuLoan\PersonalSusuLoanState;
use App\States\ExistingCustomer\Loans\GetLoan\SwiftCredit\SwiftCreditState;
use Domain\ExistingCustomer\Actions\Common\HasKycAction;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetLoanState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Terminate session if customer does not have Ghana Card
        if (! HasKycAction::execute(session: $session)) {
            return LinkKycMenu::noKycMenu(session: $session);
        }

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new PersonalSusuLoanState, 'menu' => new PersonalSusuLoanMenu],
            '2' => ['class' => new BizSusuLoanState, 'menu' => new BizSusuLoanMenu],
            '3' => ['class' => new SwiftCreditState, 'menu' => new SwiftCreditMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return GetLoanMenu::invalidMainMenu(session: $session);
    }
}
