<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MyAccount\ChangePin;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\MyAccount\ChangePin\ConfirmNewPinAction;
use Domain\User\Customer\Actions\MyAccount\ChangePin\CurrentPinAction;
use Domain\User\Customer\Actions\MyAccount\ChangePin\NewPinAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ChangePinState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'current_pin', array: $user_inputs) => CurrentPinAction::execute($session, $service_data),
            ! array_key_exists(key: 'new_pin', array: $user_inputs) => NewPinAction::execute($session, $service_data),
            ! array_key_exists(key: 'confirm_pin', array: $user_inputs) => ConfirmNewPinAction::execute($session, $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
