<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use App\Services\Customer\Requests\Pin\PinCreateRequest;
use Domain\Shared\Action\General\RegistrationValidationAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\RegistrationValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Guest\Data\Registration\PinCreateData;
use Domain\User\Guest\Menus\Registration\RegistrationMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationPinAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            RegistrationValidationAction::isNumericValid($service_data->user_input) === false => RegistrationValidationMenu::isNumericMenu(session: $session),
            RegistrationValidationAction::isPinLengthValid($service_data->user_input) === false => RegistrationValidationMenu::isPinLengthMenu(session: $session),

            default => self::registrationPin(session: $session, service_data: $service_data)
        };
    }

    public static function registrationPin(Session $session, $service_data): JsonResponse
    {
        // Execute and return the PinCreateRequest
        $response = (new PinCreateRequest)->execute(customer: $session->customer, request: PinCreateData::toArray($service_data->user_input));

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => RegistrationMenu::successResponse(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
