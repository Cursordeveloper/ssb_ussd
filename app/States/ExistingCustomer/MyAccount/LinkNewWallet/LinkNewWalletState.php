<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\LinkNewWallet;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet\MobileMoneyNumberAction;
use Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet\PinConfirmationAction;
use Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet\SelectNetworkAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Terminate the session if
        if (array_key_exists(key: 'noWallet', array: $user_inputs) && $session_data->user_input === '2') {
            return GeneralMenu::terminateSession($session->session_id);
        }

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'select_network', array: $user_inputs) => SelectNetworkAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'mobile_money_number', array: $user_inputs) => MobileMoneyNumberAction::execute(session: $session, session_data: $session_data, steps_data: $user_inputs),
            ! array_key_exists(key: 'pin_confirmation', array: $user_inputs) => PinConfirmationAction::execute(session: $session, session_data: $session_data, user_inputs: $user_inputs),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
