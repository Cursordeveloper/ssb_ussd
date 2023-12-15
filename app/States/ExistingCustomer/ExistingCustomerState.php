<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer;

use App\Common\ResponseBuilder;
use App\Menus\Account\MyAccountMenu;
use App\Menus\Insurance\InsuranceMenu;
use App\Menus\Investment\InvestmentsMenu;
use App\Menus\Loans\LoansMenu;
use App\Menus\Susu\SusuSavingsMenu;
use App\Menus\Welcome\WelcomeMenu;
use App\States\Account\MyAccountState;
use App\States\Insurance\InsuranceState;
use App\States\Investments\InvestmentsState;
use App\States\Loans\LoansState;
use App\States\Susu\SusuSavingsState;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ExistingCustomerState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Create the expected input arrays
        $options = ['1', '2', '3', '4', '5', '0'];

        // Assign the customer input to a variable
        $customer_input = $session_data->user_input;

        // If the input is '0', terminate the session
        if ($customer_input === '0') {
            return ResponseBuilder::terminateResponseBuilder(session_id: data_get(target: $session, key: 'session_id'));
        }

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new SusuSavingsState, 'menu' => new SusuSavingsMenu],
            '2' => ['class' => new LoansState, 'menu' => new LoansMenu],
            '3' => ['class' => new InvestmentsState, 'menu' => new InvestmentsMenu],
            '4' => ['class' => new InsuranceState, 'menu' => new InsuranceMenu],
            '5' => ['class' => new MyAccountState, 'menu' => new MyAccountMenu],
            '0' => null,
        ];

        // Check if the customer input is a valid option
        if (in_array($customer_input, $options) && array_key_exists($customer_input, $stateMappings)) {
            $customer_state = $stateMappings[$customer_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return WelcomeMenu::existingCustomerInvalidOption(data_get(target: $session, key: 'session_id'));
    }
}
