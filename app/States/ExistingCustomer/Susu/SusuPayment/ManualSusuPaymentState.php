<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\SusuPayment;

use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Customer\Actions\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\MakePayment\ManualSusuPaymentAction;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ManualSusuPaymentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to SusuState if user input is (0)
        if ($session_data->user_input === '0') {
            $susu_state = ['class' => new SusuState, 'menu' => new SusuMenu];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($susu_state['class']), session_data: $session_data);

            // Execute the state
            return $susu_state['menu']::mainMenu(session: $session);
        }

        // Execute the SusuPaymentAction
        return ManualSusuPaymentAction::execute(session: $session, session_data: $session_data);
    }
}
