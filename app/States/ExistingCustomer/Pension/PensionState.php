<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Pension;

use App\Menus\ExistingCustomer\ExistingCustomerMenu;
use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionMenu;
use App\Menus\ExistingCustomer\Pension\CreatePension\CreatePensionMenu;
use App\Menus\ExistingCustomer\Pension\MyPensionAccounts\MyPensionAccountsMenu;
use App\Menus\ExistingCustomer\Pension\PensionMenu;
use App\Menus\ExistingCustomer\Pension\PensionTerms\PensionTermsMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionState;
use App\States\ExistingCustomer\Pension\CreatePension\CreatePensionState;
use App\States\ExistingCustomer\Pension\MyPensionAccounts\MyPensionAccountsState;
use App\States\ExistingCustomer\Pension\PensionTerms\PensionTermsState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PensionState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new MyPensionAccountsState, 'menu' => new MyPensionAccountsMenu],
            '2' => ['class' => new CreatePensionState, 'menu' => new CreatePensionMenu],
            '3' => ['class' => new AboutPensionState, 'menu' => new AboutPensionMenu],
            '4' => ['class' => new PensionTermsState, 'menu' => new PensionTermsMenu],
            '0' => ['class' => new ExistingCustomerState, 'menu' => new ExistingCustomerMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the PensionMenu(invalidMainMenu)
        return PensionMenu::invalidMainMenu(session: $session);
    }
}
