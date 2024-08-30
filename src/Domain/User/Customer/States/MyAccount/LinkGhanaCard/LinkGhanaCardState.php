<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MyAccount\LinkGhanaCard;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\MyAccount\LinkGhanaCard\IDNumberAction;
use Domain\User\Customer\Actions\MyAccount\LinkGhanaCard\PinConfirmationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkGhanaCardState
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
