<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Insurance\AboutInsurance;

use App\Menus\ExistingCustomer\Insurance\AboutInsurance\AboutInsuranceMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceClaims\InsuranceClaimsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceCommissions\InsuranceCommissionsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceContributions\InsuranceContributionsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceCoverage\InsuranceCoverageMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsurancePayouts\InsurancePayoutsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsurancePremiums\InsurancePremiumsMenu;
use App\Menus\ExistingCustomer\Insurance\AboutInsurance\InsuranceSchemes\InsuranceSchemesMenu;
use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceClaims\InsuranceClaimsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceCommissions\InsuranceCommissionsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceContributions\InsuranceContributionsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceCoverage\InsuranceCoverageState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsurancePayouts\InsurancePayoutsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsurancePremiums\InsurancePremiumsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceSchemes\InsuranceSchemesState;
use App\States\ExistingCustomer\Insurance\InsuranceState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInsuranceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new InsuranceSchemesState, 'menu' => new InsuranceSchemesMenu],
            '2' => ['class' => new InsuranceCoverageState, 'menu' => new InsuranceCoverageMenu],
            '3' => ['class' => new InsurancePremiumsState, 'menu' => new InsurancePremiumsMenu],
            '4' => ['class' => new InsuranceContributionsState, 'menu' => new InsuranceContributionsMenu],
            '5' => ['class' => new InsuranceClaimsState, 'menu' => new InsuranceClaimsMenu],
            '6' => ['class' => new InsurancePayoutsState, 'menu' => new InsurancePayoutsMenu],
            '7' => ['class' => new InsuranceCommissionsState, 'menu' => new InsuranceCommissionsMenu],
            '0' => ['class' => new InsuranceState, 'menu' => new InsuranceMenu],
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

        // Return the invalidMainMenu
        return AboutInsuranceMenu::mainMenu(session: $session);
    }
}
