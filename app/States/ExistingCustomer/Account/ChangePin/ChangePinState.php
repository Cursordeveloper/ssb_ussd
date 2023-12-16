<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Account\ChangePin;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\ChangePin\BeginProcessAction;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\ChangePin\ConfirmNewPinAction;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\ChangePin\CurrentPinAction;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\ChangePin\NewPinAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ChangePinState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'beginProcess', array: $process_flow) => BeginProcessAction::execute($session),
            ! array_key_exists(key: 'currentPin', array: $process_flow) => CurrentPinAction::execute($session, $session_data),
            ! array_key_exists(key: 'newPin', array: $process_flow) => NewPinAction::execute($session, $session_data),
            ! array_key_exists(key: 'confirmNewPin', array: $process_flow) => ConfirmNewPinAction::execute($session, $session_data),
            default => GeneralMenu::infoNotification(
                message: 'There was a problem. Try again later.',
                session: data_get(target: $session, key: 'session_id')
            ),
        };
    }
}
