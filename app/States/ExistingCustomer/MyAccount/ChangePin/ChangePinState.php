<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\ChangePin;

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
            ! array_key_exists(key: 'begin', array: $process_flow) => BeginProcessAction::execute($session),
            ! array_key_exists(key: 'current_pin', array: $process_flow) => CurrentPinAction::execute($session, $session_data),
            ! array_key_exists(key: 'new_pin', array: $process_flow) => NewPinAction::execute($session, $session_data),
            ! array_key_exists(key: 'confirm_pin', array: $process_flow) => ConfirmNewPinAction::execute($session, $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
