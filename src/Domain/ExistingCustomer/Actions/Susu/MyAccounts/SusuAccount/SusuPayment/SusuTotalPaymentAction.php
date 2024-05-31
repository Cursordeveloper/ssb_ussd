<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuPayment;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\BizSusu\BizSusuAccountPaymentMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\Payment\SusuServiceSusuPaymentRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuTotalPaymentAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['total_payment' => $session_data->user_input]);

        // Get the process flow array from the customer session (user inputs)
        $payment_data = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $make_payment = (new SusuServiceSusuPaymentRequest)->execute(
            customer: $customer,
            payment_data: $payment_data
        );

        // Terminate session if $get_balance request status is false
        if (data_get(target: $make_payment, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Return the noSususAccount
        return BizSusuAccountPaymentMenu::narrationMenu(session: $session);
    }
}
