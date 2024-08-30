<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\Insurance;

use App\Menus\ExistingCustomer\Insurance\AboutInsurance\AboutInsuranceMenu;
use App\Menus\ExistingCustomer\Insurance\CreateInsurance\CreateInsuranceMenu;
use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use App\Menus\ExistingCustomer\Insurance\InsuranceTerms\InsuranceTermsMenu;
use App\Menus\ExistingCustomer\Insurance\MyInsuranceAccounts\MyInsuranceAccountsMenu;
use App\States\ExistingCustomer\Insurance\CreateInsurance\CreateInsuranceState;
use App\States\ExistingCustomer\Insurance\InsuranceTerms\InsuranceTermsState;
use Domain\Insurance\Shared\AboutInsurance\AboutInsuranceState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\MyInsuranceAccounts\MyInsuranceAccountsState;
use Domain\User\Customer\States\Welcome\CustomerWelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new MyInsuranceAccountsState, 'menu' => new MyInsuranceAccountsMenu],
            '2' => ['class' => new CreateInsuranceState, 'menu' => new CreateInsuranceMenu],
            '3' => ['class' => new AboutInsuranceState, 'menu' => new AboutInsuranceMenu],
            '4' => ['class' => new InsuranceTermsState, 'menu' => new InsuranceTermsMenu],
            '0' => ['class' => new CustomerWelcomeState, 'menu' => new CustomerWelcomeMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the InsuranceMenu(invalidMainMenu)
        return InsuranceMenu::invalidMainMenu(session: $session);
    }
}
