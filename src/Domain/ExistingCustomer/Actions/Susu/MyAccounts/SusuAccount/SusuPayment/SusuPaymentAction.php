<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuPayment;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuPaymentAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'start_payment', array: $user_inputs) => StartPaymentAction::execute(session: $session, user_inputs: $user_inputs),
            ! array_key_exists(key: 'total_payments', array: $user_inputs) => TotalPaymentsAction::execute(session: $session, session_data: $session_data, user_inputs: $user_inputs),
            ! array_key_exists(key: 'confirmation', array: $user_inputs) => ConfirmationAction::execute(session: $session, customer: $customer, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
