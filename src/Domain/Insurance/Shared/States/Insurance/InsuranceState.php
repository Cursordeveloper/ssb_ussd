<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\States\Insurance;

use Domain\Insurance\Shared\Menus\AboutInsurance\AboutInsuranceMenu;
use Domain\Insurance\Shared\Menus\Insurance\InsuranceMenu;
use Domain\Insurance\Shared\Menus\InsuranceTerms\InsuranceTermsMenu;
use Domain\Insurance\Shared\Menus\StartInsurance\StartInsuranceMenu;
use Domain\Insurance\Shared\States\AboutInsurance\AboutInsuranceState;
use Domain\Insurance\Shared\States\InsuranceTerms\InsuranceTermsState;
use Domain\Insurance\Shared\States\StartInsurance\StartInsuranceState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyInsuranceAccounts\MyInsuranceAccountsMenu;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\MyInsuranceAccounts\MyInsuranceAccountsState;
use Domain\User\Customer\States\Welcome\CustomerWelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new MyInsuranceAccountsState, 'menu' => new MyInsuranceAccountsMenu],
            '2' => ['class' => new StartInsuranceState, 'menu' => new StartInsuranceMenu],
            '3' => ['class' => new AboutInsuranceState, 'menu' => new AboutInsuranceMenu],
            '4' => ['class' => new InsuranceTermsState, 'menu' => new InsuranceTermsMenu],
            '0' => ['class' => new CustomerWelcomeState, 'menu' => new CustomerWelcomeMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($service_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), service_data: $service_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the InsuranceMenu(invalidMainMenu)
        return InsuranceMenu::invalidMainMenu(session: $session);
    }
}
