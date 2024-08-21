<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\LinkNewWallet;

use Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet\ApprovalAction;
use Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet\MobileNumberAction;
use Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet\NetworkAction;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'scheme_resource_id', array: $user_inputs) => NetworkAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'mobile_number', array: $user_inputs) => MobileNumberAction::execute(session: $session, session_data: $session_data, steps_data: $user_inputs),
            ! array_key_exists(key: 'approval', array: $user_inputs) => ApprovalAction::execute(session: $session, session_data: $session_data, user_inputs: $user_inputs),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
