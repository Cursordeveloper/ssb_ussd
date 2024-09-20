<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\States\AboutInsurance;

use Domain\Insurance\Shared\Menus\AboutInsurance\AboutInsuranceMenu;
use Domain\Insurance\Shared\Menus\AboutInsurance\InsuranceClaims\InsuranceClaimsMenu;
use Domain\Insurance\Shared\Menus\AboutInsurance\InsuranceCommissions\InsuranceCommissionsMenu;
use Domain\Insurance\Shared\Menus\AboutInsurance\InsuranceContributions\InsuranceContributionsMenu;
use Domain\Insurance\Shared\Menus\AboutInsurance\InsuranceCoverage\InsuranceCoverageMenu;
use Domain\Insurance\Shared\Menus\AboutInsurance\InsurancePayouts\InsurancePayoutsMenu;
use Domain\Insurance\Shared\Menus\AboutInsurance\InsurancePremiums\InsurancePremiumsMenu;
use Domain\Insurance\Shared\Menus\AboutInsurance\InsuranceSchemes\InsuranceSchemesMenu;
use Domain\Insurance\Shared\Menus\Insurance\InsuranceMenu;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceClaims\AboutInsuranceClaimsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceCommissions\AboutInsuranceCommissionsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceContributions\AboutInsuranceContributionsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceCoverage\AboutInsuranceCoverageState;
use Domain\Insurance\Shared\States\AboutInsurance\InsurancePayouts\AboutInsurancePayoutsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsurancePremiums\AboutInsurancePremiumsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceSchemes\AboutInsuranceSchemesState;
use Domain\Insurance\Shared\States\Insurance\InsuranceState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInsuranceState
{
    public static function execute(Session $session, $service_data): JsonResponse
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
        if (array_key_exists(key: $service_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), service_data: $service_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutInsuranceMenu::mainMenu(session: $session);
    }
}
