<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\NewCustomer\Registration;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Customer\CustomerService;
use Domain\Customer\DTO\PinCreateDTO;
use Domain\Customer\Models\Customer;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerCreatePinAction
{
    public static function execute(Customer $customer, Session $session, $session_data): JsonResponse
    {
        // Terminate the session if validation failed
        if (is_numeric($session_data->user_input) && strlen((string) $session_data->user_input) === 4) {
            $pin_created = (new CustomerService)->createPin(PinCreateDTO::toArray($customer, $session_data->user_input));

            // Return a success response
            if (data_get($pin_created, key: 'status') === true) {
                return RegistrationMenu::successResponse(data_get(target: $session, key: 'session_id'));
            }

            // Return registrations failed response
            return GeneralMenu::infoNotification(
                session: $session,
                message: 'Pin creation failed. Try again later',
            );
        }

        // Terminate the session
        return GeneralMenu::invalidInput(data_get(target: $session, key: 'session_id'));
    }
}
