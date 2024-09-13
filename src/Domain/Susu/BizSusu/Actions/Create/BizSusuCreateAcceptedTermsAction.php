<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Create;

use App\Services\Susu\Data\BizSusu\Create\BizSusuCreateData;
use App\Services\Susu\Requests\BizSusu\Create\BizSusuCreateRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Create\BizSusuCreateMenu;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateAcceptedTermsAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return match (true) {
            $session_data->user_input === '1' => self::susuCreateRequest(session: $session),
            $session_data->user_input === '2' => GeneralMenu::processCancelNotification(session: $session),

            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    public static function susuCreateRequest(Session $session): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the BizSusuCreateRequest HTTP request
        $susu_created = (new BizSusuCreateRequest)->execute(customer: $customer, data: BizSusuCreateData::toArray(json_decode($session->user_inputs, associative: true)));

        // Update the user_put and return the narrationMenu
        if (data_get($susu_created, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'susu_resource' => data_get($susu_created, key: 'data.attributes.resource_id')]);
            return BizSusuCreateMenu::narrationMenu(session: $session, susu_data: data_get($susu_created, key: 'data.attributes'), linked_account: data_get($susu_created, key: 'data.included.wallet.attributes'));
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
