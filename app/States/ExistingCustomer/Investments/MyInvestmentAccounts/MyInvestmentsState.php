<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments\MyInvestmentAccounts;

use App\Menus\ExistingCustomer\Investment\MyInvestmentAccounts\MyInvestmentAccountsMenu;
use Domain\Shared\Action\Common\ReturnToServiceAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyInvestmentsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the InvestmentState if user input is (0)
        if ($session_data->user_input === '0') {
            return ReturnToServiceAction::execute(session: $session, session_data: $session_data, service: 'investment');
        }

        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Execute the SusuAccountState if user input is valid
        if (array_key_exists(key: $session_data->user_input, array: $user_data['investment_accounts'])) {
            // Reset user data and input
            SessionInputUpdateAction::resetUserData(session: $session);
        }

        // Execute MySusuAccountsAction action
        return MyInvestmentAccountsMenu::invalidMainMenu(session: $session);
    }
}
