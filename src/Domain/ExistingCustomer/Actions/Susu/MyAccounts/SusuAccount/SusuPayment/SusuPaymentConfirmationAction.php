<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuPayment;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuPaymentConfirmationAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['confirmation' => true]);

        // Get the session user_data
        //        $user_data = json_decode($session->user_data, associative: true);

        // Get the customer
        //        $customer = GetCustomerAction::execute($session->phone_number);

        // Return the createAccountNotification and terminate the session
        return GeneralMenu::requestNotification(session: $session);

        //        // Execute the createPersonalSusu HTTP request
        //        $susu_approved = (new ApprovePersonalSusu)->execute(customer: $customer, data: PinApprovalData::toArray($session_data->user_input), susu_resource: $user_data['susu_resource']);
        //
        //        // Return a success response
        //        if (data_get($susu_approved, key: 'status') === true) {
        //            // Update the user inputs (steps)
        //            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['confirmation' => true]);
        //
        //            // Return the createAccountNotification and terminate the session
        //            return GeneralMenu::createAccountNotification(session: $session);
        //        }

        // Return system error menu
        //        return GeneralMenu::invalidInput(session: $session);
    }
}
