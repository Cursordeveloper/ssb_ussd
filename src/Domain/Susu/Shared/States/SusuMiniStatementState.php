<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuMiniStatement\SusuMiniStatementAction;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Account\PersonalSusuAccountMenu;
use Domain\Susu\PersonalSusu\States\Account\PersonalSusuAccountState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuMiniStatementState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SessionInputUpdateAction, SusuMiniStatementAction and return the transactions
        if (! array_key_exists(key: 'approval', array: $user_inputs)) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['approval' => true, 'page' => 1]);
            return SusuMiniStatementAction::newTransaction(session: $session, customer: $customer, user_inputs: $user_inputs);
        }

        // Execute the SusuMiniStatementAction and return the transactions
        if ($session_data->user_input === '#') {
            return SusuMiniStatementAction::nextTransaction(session: $session, customer: $customer, user_inputs: $user_inputs, page: data_get(target: $user_inputs, key: 'page'));
        }

        // If the user_input is '0', return back to PersonalSusuAccountState
        if ($session_data->user_input === '0') {
            UpdateSessionStateAction::execute(session: $session, state: class_basename(class: PersonalSusuAccountState::class), session_data: $session_data);
            return PersonalSusuAccountMenu::mainMenu(session: $session);
        }

        // Return the systemErrorNotification and terminate the session
        return GeneralMenu::invalidInput($session);
    }
}
