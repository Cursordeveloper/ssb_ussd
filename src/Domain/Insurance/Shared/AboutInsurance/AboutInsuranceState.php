<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\AboutInsurance;

use App\Menus\ExistingCustomer\Insurance\AboutInsurance\AboutInsuranceMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceClaims\InsuranceClaimsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceCommissions\InsuranceCommissionsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceContributions\InsuranceContributionsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceCoverage\InsuranceCoverageMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsurancePayouts\InsurancePayoutsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsurancePremiums\InsurancePremiumsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceSchemes\InsuranceSchemesMenu;
use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceClaims\AboutInsuranceClaimsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceCommissions\AboutInsuranceCommissionsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceContributions\AboutInsuranceContributionsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceCoverage\AboutInsuranceCoverageState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsurancePayouts\AboutInsurancePayoutsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsurancePremiums\AboutInsurancePremiumsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceSchemes\AboutInsuranceSchemesState;
use Domain\Insurance\Shared\Insurance\InsuranceState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInsuranceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new AboutInsuranceSchemesState, 'menu' => new InsuranceSchemesMenu],
            '2' => ['class' => new AboutInsuranceCoverageState, 'menu' => new InsuranceCoverageMenu],
            '3' => ['class' => new AboutInsurancePremiumsState, 'menu' => new InsurancePremiumsMenu],
            '4' => ['class' => new AboutInsuranceContributionsState, 'menu' => new InsuranceContributionsMenu],
            '5' => ['class' => new AboutInsuranceClaimsState, 'menu' => new InsuranceClaimsMenu],
            '6' => ['class' => new AboutInsurancePayoutsState, 'menu' => new InsurancePayoutsMenu],
            '7' => ['class' => new AboutInsuranceCommissionsState, 'menu' => new InsuranceCommissionsMenu],
            '0' => ['class' => new InsuranceState, 'menu' => new InsuranceMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutInsuranceMenu::mainMenu(session: $session);
    }
}
