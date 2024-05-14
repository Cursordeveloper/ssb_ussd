<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\BizSusu\CreateBizSusuMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Data\BizSusu\BizSusuCreateData;
use App\Services\Susu\Requests\BizSusu\BizSusuCreateRequest;
use Domain\ExistingCustomer\Actions\Common\CustomerLinkedWalletsAction;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the CustomerLinkedWalletsAction
        if (! CustomerLinkedWalletsAction::execute(session: $session, session_data: $session_data)) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the BizSusuCreateRequest HTTP request
        $susu_created = (new BizSusuCreateRequest)->execute(customer: $customer, data: BizSusuCreateData::toArray(json_decode($session->user_inputs, associative: true)));

        // Return a success response
        if (data_get($susu_created, key: 'code') === 200) {
            // Update the user_data with the new susu_created resource
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_resource' => data_get($susu_created, key: 'data.attributes.resource_id')]);

            // Return the confirmTermsConditionsMenu
            return CreateBizSusuMenu::narrationMenu(session: $session, susu_data: data_get($susu_created, key: 'data.attributes'));
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
