<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use App\Services\Susu\Data\GoalGetterSusu\GoalGetterSusuCreateData;
use App\Services\Susu\Requests\GoalGetterSusu\GoalGetterSusuCreateRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Create\GoalGetterSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateAcceptedTermsAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the invalidAcceptedSusuTerms menu if user_input is not 1
        if ($session_data->user_input !== '1') {
            return GeneralMenu::invalidAcceptedSusuTerms(session: $session);
        }

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the GoalGetterSusuCreateRequest HTTP request
        $susu_created = (new GoalGetterSusuCreateRequest)->execute(customer: $customer, data: GoalGetterSusuCreateData::toArray(json_decode($session->user_inputs, associative: true)));

        // Update the user_put and return the narrationMenu
        if (data_get($susu_created, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'susu_resource' => data_get($susu_created, key: 'data.attributes.resource_id')]);

            // Return the confirmTermsConditionsMenu
            return GoalGetterSusuCreateMenu::narrationMenu(session: $session, susu_data: data_get($susu_created, key: 'data.attributes'), linked_account: data_get($susu_created, key: 'data.included.wallet.attributes'), duration: data_get($susu_created, key: 'data.included.duration.attributes'));
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
