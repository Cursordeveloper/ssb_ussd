<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuBalance;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuBalance\SusuBalanceMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Customer\Customer;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PinPromptAction
{
    public static function execute(Session $session, Customer $customer, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['begin' => true]);

        // Return the CheckBalanceMenu
        return SusuBalanceMenu::confirmation(session: $session);
    }
}
