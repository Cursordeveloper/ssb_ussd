<?php

declare(strict_types=1);

namespace Domain\NewCustomer\Actions\Registration;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Services\Customer\Requests\Pin\PinCreateRequest;
use Domain\NewCustomer\Data\Registration\PinCreateData;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Customer\Customer;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerCreatePinAction
{
    public static function execute(Customer $customer, Session $session, $session_data): JsonResponse
    {
        // Terminate the session if validation failed
        if (is_numeric($session_data->user_input) && strlen((string) $session_data->user_input) === 4) {
            $pin_created = (new PinCreateRequest)->execute(customer: $customer, request: PinCreateData::toArray($session_data->user_input));

            // Return a success response
            if (data_get($pin_created, key: 'status') === true) {
                return RegistrationMenu::successResponse(session: $session);
            }

            // Return registrations failed response
            return GeneralMenu::infoNotification(session: $session, message: 'Pin creation failed. Try again later');
        }

        // Terminate the session
        return GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id'));
    }
}
