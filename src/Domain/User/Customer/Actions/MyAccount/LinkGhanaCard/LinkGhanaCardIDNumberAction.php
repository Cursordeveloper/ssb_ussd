<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\LinkGhanaCard;

use App\Services\Customer\Data\Kyc\CustomerServiceLinkGhanaCardData;
use App\Services\Customer\Requests\Kyc\CustomerServiceLinkGhanaCardRequest;
use Domain\Shared\Action\General\LinkGhanaCardValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\LinkGhanaCardValidationMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkGhanaCardIDNumberAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate inputs and update the database
        return match (true) {
            LinkGhanaCardValidationAction::isGhanaCardValid(user_input: $service_data->user_input) === false => LinkGhanaCardValidationMenu::isGhanaCardMenu(session: $session),

            default => self::linkGhanaCardRequest(session: $session, service_data: $service_data),
        };
    }

    public static function linkGhanaCardRequest(Session $session, $service_data): JsonResponse
    {
        // Execute and return the CustomerServiceLinkGhanaCardRequest
        $response = (new CustomerServiceLinkGhanaCardRequest)->execute(
            customer: $session->customer,
            data: CustomerServiceLinkGhanaCardData::toArray(id_number: $service_data->user_input),
        );

        // Return the enterPinMenu if status is true
        if (data_get(target: $response, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['id_number' => true, 'kyc_resource_id' => data_get(target: $response, key: 'data.attributes.resource_id')]);

            return GeneralMenu::pinMenu(session: $session);
        }

        // Return the systemErrorNotification
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
