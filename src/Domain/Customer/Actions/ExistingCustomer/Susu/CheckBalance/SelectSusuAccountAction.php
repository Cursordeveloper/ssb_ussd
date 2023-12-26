<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CheckBalance;

use App\Menus\ExistingCustomer\Susu\CheckBalance\CheckBalanceMenu;
use Domain\Customer\Models\Customer;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SelectSusuAccountAction
{
    public static function execute(Session $session, Customer $customer, $session_data): JsonResponse
    {
        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Prepare the and return the susu accounts
        if (array_key_exists(key: $session_data->user_input, array: $user_data['susu_accounts'])) {
            // Update the user inputs (steps)
            SessionInputUpdateAction::execute(session: $session, user_input: ['susu_account' => $user_data['susu_accounts'][$session_data->user_input]['resource_id']]);

            // Return the susuBalanceMenu
            return CheckBalanceMenu::confirmation(session: $session);
        }

        // Return the noSususAccount
        return CheckBalanceMenu::invalidSusuAccountsMenu(session: $session, susu_data: $user_data);
    }
}
