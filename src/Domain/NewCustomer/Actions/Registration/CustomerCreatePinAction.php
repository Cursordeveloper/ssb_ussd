<?php

declare(strict_types=1);

namespace Domain\NewCustomer\Actions\Registration;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Customer\CustomerService;
use Domain\NewCustomer\Data\Registration\PinCreateData;
use Domain\Shared\Models\Customer\Customer;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerCreatePinAction
{
    public static function execute(Customer $customer, Session $session, $session_data): JsonResponse
    {
        // Terminate the session if validation failed
        if (is_numeric($session_data->user_input) && strlen((string) $session_data->user_input) === 4) {
            $pin_created = (new CustomerService)->createPin(PinCreateData::toArray($customer, $session_data->user_input));

            // Return a success response
            if (data_get($pin_created, key: 'status') === true) {
                return RegistrationMenu::successResponse(data_get(target: $session, key: 'session_id'));
            }

            // Return registrations failed response
            return GeneralMenu::infoNotification(session: $session, message: 'Pin creation failed. Try again later');
        }

        // Terminate the session
        return GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id'));
    }
}
