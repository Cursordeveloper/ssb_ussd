<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Account\LinkNewWallet;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkNewAccount\BeginProcessAction;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkNewAccount\MobileMoneyNumberAction;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkNewAccount\PinConfirmationAction;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkNewAccount\SelectNetworkAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'beginProcess', array: $process_flow) => BeginProcessAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'selectNetwork', array: $process_flow) => SelectNetworkAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'mobileMoneyNumber', array: $process_flow) => MobileMoneyNumberAction::execute(session: $session, session_data: $session_data, steps_data: $process_flow),
            ! array_key_exists(key: 'pinConfirmation', array: $process_flow) => PinConfirmationAction::execute(session: $session, session_data: $session_data, steps_data: $process_flow),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
