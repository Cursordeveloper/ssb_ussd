<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\LinkGhanaCard;

use App\Services\Customer\Data\Kyc\CustomerServiceLinkGhanaCardCancellationData;
use App\Services\Customer\Requests\Kyc\CustomerServiceLinkGhanaCardApprovalRequest;
use App\Services\Customer\Requests\Kyc\CustomerServiceLinkGhanaCardCancellationRequest;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkGhanaCardApprovalAction
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
        // Execute the CustomerServiceLinkGhanaCardApprovalRequest HTTP request
        $response = (new CustomerServiceLinkGhanaCardApprovalRequest)->execute(
            customer: $session->customer,
            kyc_resource: $session->userInputs()['kyc_resource_id'],
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
        // Execute the CustomerServiceLinkGhanaCardCancellationRequest HTTP request
        $response = (new CustomerServiceLinkGhanaCardCancellationRequest)->execute(
            customer: $session->customer,
            kyc_resource: $session->userInputs()['kyc_resource_id'],
            data: CustomerServiceLinkGhanaCardCancellationData::toArray(),
        );

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::infoNotification(session: $session, message: data_get(target: $response, key: 'description')),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
