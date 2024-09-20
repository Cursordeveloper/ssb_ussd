<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Collection\Summary;

use App\Services\Customer\Requests\Pin\CustomerServicePinApprovalRequest;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Collection\Summary\PersonalSusuCollectionSummaryMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionSummaryApprovalAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $service_data->user_input === '2' => GeneralMenu::processTerminatedMenu(session: $session),

            default => self::approval(session: $session, service_data: $service_data)
        };
    }

    public static function approval(Session $session, $service_data): JsonResponse
    {
        // Execute the createPersonalSusu HTTP request
        $response = (new CustomerServicePinApprovalRequest)->execute(customer: $session->customer, data: PinApprovalData::toArray($service_data->user_input));

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => PersonalSusuCollectionSummaryMenu::narrationMenu(session: $session),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
