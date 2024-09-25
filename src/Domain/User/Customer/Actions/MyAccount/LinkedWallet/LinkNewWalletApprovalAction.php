<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\LinkedWallet;

use App\Services\Customer\Data\LinkedAccount\CustomerServiceLinkNewAccountCancellationData;
use App\Services\Customer\Requests\LinkedAccount\CustomerServiceLinkNewAccountApprovalRequest;
use App\Services\Customer\Requests\LinkedAccount\CustomerServiceLinkNewAccountCancellationRequest;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletApprovalAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $service_data->user_input === '2' => self::cancellation(session: $session),

            default => self::approval(session: $session, service_data: $service_data)
        };
    }

    public static function approval(Session $session, $service_data): JsonResponse
    {
        // Execute the CustomerServiceLinkNewAccountCancellationRequest HTTP request
        $response = (new CustomerServiceLinkNewAccountApprovalRequest)->execute(
            customer: $session->customer,
            linked_account: $session->userInputs()['linked_account_resource_id'],
            data: PinApprovalData::toArray(pin: $service_data->user_input)
        );

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::requestNotification(session: $session),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),
            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function cancellation(Session $session): JsonResponse
    {
        // Execute the CustomerServiceLinkNewAccountCancellationRequest HTTP request
        $response = (new CustomerServiceLinkNewAccountCancellationRequest)->execute(
            customer: $session->customer,
            linked_account: $session->userInputs()['linked_account_resource_id'],
            data: CustomerServiceLinkNewAccountCancellationData::toArray(),
        );

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::infoNotification(session: $session, message: data_get(target: $response, key: 'description')),
            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
