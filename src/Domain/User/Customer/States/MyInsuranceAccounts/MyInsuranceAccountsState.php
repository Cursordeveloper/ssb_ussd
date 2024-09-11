<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MyInsuranceAccounts;

use Domain\Shared\Action\Common\ReturnToServiceAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyInsuranceAccounts\MyInsuranceAccountsMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyInsuranceAccountsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the InsuranceState if user input is (0)
        if ($session_data->user_input === '0') {
            return ReturnToServiceAction::execute(session: $session, session_data: $session_data, service: 'insurance');
        }

        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Execute the SusuAccountState if user input is valid
        if (array_key_exists(key: $session_data->user_input, array: $user_data['insurance_accounts'])) {
            // Reset user data and input
            SessionInputUpdateAction::resetUserData(session: $session);
        }

        // Execute MySusuAccountsAction action
        return MyInsuranceAccountsMenu::invalidMainMenu(session: $session);
    }
}
