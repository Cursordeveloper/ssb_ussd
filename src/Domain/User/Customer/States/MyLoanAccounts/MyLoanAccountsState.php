<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MyLoanAccounts;

use Domain\Shared\Action\Common\ReturnToServiceAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyLoanAccounts\MyLoanAccountsMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyLoanAccountsState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Return to the LoanState if user input is (0)
        if ($service_data->user_input === '0') {
            return ReturnToServiceAction::execute(session: $session, service_data: $service_data, service: 'loan');
        }

        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Execute the SusuAccountState if user input is valid
        if (array_key_exists(key: $service_data->user_input, array: $user_data['loan_accounts'])) {
            // Reset user data and input
            SessionInputUpdateAction::resetUserData(session: $session);
        }

        // Execute MySusuAccountsAction action
        return MyLoanAccountsMenu::invalidMainMenu(session: $session);
    }
}
