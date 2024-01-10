<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\CheckBalance;

use App\Menus\ExistingCustomer\Susu\CheckBalance\CheckBalanceMenu;
use Domain\Customer\Models\Customer;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PinPromptAction
{
    public static function execute(Session $session, Customer $customer, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['begin' => true]);

        // Return the CheckBalanceMenu
        return CheckBalanceMenu::confirmation(session: $session);
    }
}
