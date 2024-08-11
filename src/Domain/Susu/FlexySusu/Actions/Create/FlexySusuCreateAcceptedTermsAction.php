<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Create;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Data\FlexySusu\FlexySusuCreateData;
use App\Services\Susu\Requests\FlexySusu\FlexySusuCreateRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Create\FlexySusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateAcceptedTermsAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the invalidAcceptedSusuTerms menu if user_input is not 1
        if ($session_data->user_input !== '1') {
            return GeneralMenu::invalidAcceptedSusuTerms(session: $session);
        }

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the FlexySusuCreateRequest HTTP request
        $susu_created = (new FlexySusuCreateRequest)->execute(customer: $customer, data: FlexySusuCreateData::toArray(json_decode($session->user_inputs, associative: true)));

        // Update the user_put and return the narrationMenu
        if (data_get($susu_created, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'susu_resource' => data_get($susu_created, key: 'data.attributes.resource_id')]);

            // Return the confirmTermsConditionsMenu
            return FlexySusuCreateMenu::narrationMenu(session: $session, susu_data: data_get($susu_created, key: 'data.attributes'), linked_account: data_get($susu_created, key: 'data.included.wallet.attributes'));
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
