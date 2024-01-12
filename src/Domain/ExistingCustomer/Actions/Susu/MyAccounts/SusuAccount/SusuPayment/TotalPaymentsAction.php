<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuPayment;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPayment\SusuPaymentMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TotalPaymentsAction
{
    public static function execute(Session $session, $session_data, $user_inputs): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['total_payments' => $session_data->user_input]);

        // Return the noSususAccount
        return SusuPaymentMenu::narrationMenu(session: $session);
    }
}
