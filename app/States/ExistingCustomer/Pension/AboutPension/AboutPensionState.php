<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Pension\AboutPension;

use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionBenefits\AboutPensionBenefitsMenu;
use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionCommissions\AboutPensionCommissionsMenu;
use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionContributions\AboutPensionContributionsMenu;
use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionGuarantees\AboutPensionGuaranteesMenu;
use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionMenu;
use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionPayouts\AboutPensionPayoutsMenu;
use App\Menus\ExistingCustomer\Pension\AboutPension\AboutPensionSchemes\AboutPensionSchemesMenu;
use App\Menus\ExistingCustomer\Pension\PensionMenu;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionBenefits\AboutPensionBenefitsState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionCommissions\AboutPensionCommissionsState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionContributions\AboutPensionContributionsState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionGuarantees\AboutPensionGuaranteesState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionPayouts\AboutPensionPayoutsState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionSchemes\AboutPensionSchemesState;
use App\States\ExistingCustomer\Pension\PensionState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
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
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutPensionMenu::mainMenu(session: $session);
    }
}
