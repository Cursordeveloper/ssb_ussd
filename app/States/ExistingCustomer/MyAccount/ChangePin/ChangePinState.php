<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\ChangePin;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\MyAccount\ChangePin\ConfirmNewPinAction;
use Domain\ExistingCustomer\Actions\MyAccount\ChangePin\CurrentPinAction;
use Domain\ExistingCustomer\Actions\MyAccount\ChangePin\NewPinAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ChangePinState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'current_pin', array: $user_inputs) => CurrentPinAction::execute($session, $session_data),
            ! array_key_exists(key: 'new_pin', array: $user_inputs) => NewPinAction::execute($session, $session_data),
            ! array_key_exists(key: 'confirm_pin', array: $user_inputs) => ConfirmNewPinAction::execute($session, $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
