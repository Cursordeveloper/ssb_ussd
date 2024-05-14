<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\FlexySave\CreateFlexySusuMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Data\FlexySusu\FlexySusuCreateData;
use App\Services\Susu\Requests\FlexySusu\FlexySusuCreateRequest;
use Domain\ExistingCustomer\Actions\Common\CustomerLinkedWalletsAction;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the LinkedWalletAction
        if (! CustomerLinkedWalletsAction::execute(session: $session, session_data: $session_data)) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the CreateBizSusu HTTP request
        $susu_created = (new FlexySusuCreateRequest)->execute(customer: $customer, data: FlexySusuCreateData::toArray(json_decode($session->user_inputs, associative: true)));

        // Return a success response
        if (data_get($susu_created, key: 'code') === 200) {
            // Update the user_data with the new susu_created resource
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_resource' => data_get($susu_created, key: 'data.attributes.resource_id')]);

            // Return the confirmTermsConditionsMenu
            return CreateFlexySusuMenu::narrationMenu(session: $session, susu_data: data_get($susu_created, key: 'data.attributes'));
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
