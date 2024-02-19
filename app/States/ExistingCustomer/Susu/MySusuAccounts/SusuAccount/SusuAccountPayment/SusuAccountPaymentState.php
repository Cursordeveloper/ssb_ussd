<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountPayment;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuPayment\SusuPaymentConfirmationAction;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuPayment\SusuTotalPaymentAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountPaymentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'total_payment', array: $user_inputs) => SusuTotalPaymentAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'confirmation', array: $user_inputs) => SusuPaymentConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
