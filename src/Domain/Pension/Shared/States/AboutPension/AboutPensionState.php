<?php

declare(strict_types=1);

namespace Domain\Pension\Shared\States\AboutPension;

use Domain\Pension\Shared\Menus\AboutPension\AboutPensionBenefits\AboutPensionBenefitsMenu;
use Domain\Pension\Shared\Menus\AboutPension\AboutPensionCommissions\AboutPensionCommissionsMenu;
use Domain\Pension\Shared\Menus\AboutPension\AboutPensionContributions\AboutPensionContributionsMenu;
use Domain\Pension\Shared\Menus\AboutPension\AboutPensionGuarantees\AboutPensionGuaranteesMenu;
use Domain\Pension\Shared\Menus\AboutPension\AboutPensionMenu;
use Domain\Pension\Shared\Menus\AboutPension\AboutPensionPayouts\AboutPensionPayoutsMenu;
use Domain\Pension\Shared\Menus\AboutPension\AboutPensionSchemes\AboutPensionSchemesMenu;
use Domain\Pension\Shared\Menus\Pension\PensionMenu;
use Domain\Pension\Shared\States\AboutPension\AboutPensionBenefits\AboutPensionBenefitsState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionCommissions\AboutPensionCommissionsState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionContributions\AboutPensionContributionsState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionGuarantees\AboutPensionGuaranteesState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionPayouts\AboutPensionPayoutsState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionSchemes\AboutPensionSchemesState;
use Domain\Pension\Shared\States\Pension\PensionState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutPensionState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new AboutPensionSchemesState, 'menu' => new AboutPensionSchemesMenu],
            '2' => ['class' => new AboutPensionBenefitsState, 'menu' => new AboutPensionBenefitsMenu],
            '3' => ['class' => new AboutPensionGuaranteesState, 'menu' => new AboutPensionGuaranteesMenu],
            '4' => ['class' => new AboutPensionContributionsState, 'menu' => new AboutPensionContributionsMenu],
            '5' => ['class' => new AboutPensionPayoutsState, 'menu' => new AboutPensionPayoutsMenu],
            '6' => ['class' => new AboutPensionCommissionsState, 'menu' => new AboutPensionCommissionsMenu],
            '0' => ['class' => new PensionState, 'menu' => new PensionMenu],
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

        // Return the invalidMainMenu
        return AboutPensionMenu::mainMenu(session: $session);
    }
}
