<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Collection\Summary;

use App\Services\Customer\Requests\Pin\CustomerServicePinApprovalRequest;
use Domain\ExistingCustomer\Data\Common\PinApprovalData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Collection\Summary\PersonalSusuCollectionSummaryMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionSummaryApprovalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['approval' => true]);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $balance = (new CustomerServicePinApprovalRequest)->execute(customer: $customer, data: PinApprovalData::toArray($session_data->user_input));

        // Terminate session if $get_balance request status is false
        if (data_get(target: $balance, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Return the requestNotification and terminate the session
        return PersonalSusuCollectionSummaryMenu::narrationMenu(session: $session);
    }
}
