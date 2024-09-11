<?php

declare(strict_types=1);

namespace Domain\Loan\Shared\States\GetLoan;

use Domain\Loan\BizSusuLoan\Menus\Account\BizSusuLoanAccountMenu;
use Domain\Loan\BizSusuLoan\States\Account\BizSusuLoanAccountState;
use Domain\Loan\PersonalSusuLoan\Menus\Account\PersonalSusuLoanAccountMenu;
use Domain\Loan\PersonalSusuLoan\States\Account\PersonalSusuLoanAccountState;
use Domain\Loan\Shared\Menus\GetLoan\GetLoanMenu;
use Domain\Loan\SwiftLoan\Menus\Account\SwiftLoanAccountMenu;
use Domain\Loan\SwiftLoan\States\Account\SwiftLoanAccountState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\HasLinkedGhanaCardAction;
use Domain\User\Customer\Menus\MyAccount\LinkGhanaCard\LinkGhCardMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetLoanState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Terminate session if customer does not have Ghana Card
        if (! HasLinkedGhanaCardAction::execute(session: $session)) {
            return LinkGhCardMenu::noKycMenu(session: $session);
        }

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new PersonalSusuLoanAccountState, 'menu' => new PersonalSusuLoanAccountMenu],
            '2' => ['class' => new BizSusuLoanAccountState, 'menu' => new BizSusuLoanAccountMenu],
            '3' => ['class' => new SwiftLoanAccountState, 'menu' => new SwiftLoanAccountMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return GetLoanMenu::invalidMainMenu(session: $session);
    }
}
