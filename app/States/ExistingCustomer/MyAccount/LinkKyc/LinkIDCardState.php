<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\LinkKyc;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\MyAccount\LinkKyc\IDNumberAction;
use Domain\ExistingCustomer\Actions\MyAccount\LinkKyc\PinConfirmationAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkIDCardState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'id_number', array: $user_inputs) => IDNumberAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'pin_confirmation', array: $user_inputs) => PinConfirmationAction::execute(session: $session, session_data: $session_data, user_inputs: $user_inputs),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
