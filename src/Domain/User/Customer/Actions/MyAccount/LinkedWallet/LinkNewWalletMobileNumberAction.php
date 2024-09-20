<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\LinkedWallet;

use App\Services\Customer\Data\LinkedAccount\CustomerServiceLinkNewAccountApprovalData;
use App\Services\Customer\Requests\LinkedAccount\LinkNewAccountRequest;
use Domain\Shared\Action\General\LinkAccountValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\LinkAccountValidationMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletMobileNumberAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate inputs and update the database
        return match (true) {
            LinkAccountValidationAction::isPhoneNumberLengthValid(user_input: $service_data->user_input) === false => LinkAccountValidationMenu::isPhoneNumberLengthMenu(session: $session),
            LinkAccountValidationAction::isPhoneNumberValid(user_input: $service_data->user_input) === false => LinkAccountValidationMenu::isPhoneNumberMenu(session: $session),

            default => self::schemeStore(session: $session, service_data: $service_data),
        };
    }

    public static function schemeStore(Session $session, $service_data): JsonResponse
    {
        // Execute and return the PinCreateRequest
        $response = (new LinkNewAccountRequest)->execute(
            customer: $session->customer,
            data: CustomerServiceLinkNewAccountApprovalData::toArray(phone_number: $service_data->user_input, resource_id: $session->userInputs()['scheme_resource_id']),
        );

        // Update the user_put and return the narrationMenu
        if (data_get($response, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['mobile_number' => true, 'linked_account_resource_id' => data_get(target: $response, key: 'data.attributes.resource_id')]);

            return GeneralMenu::pinMenu(session: $session);
        }

        // Return the systemErrorNotification
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
