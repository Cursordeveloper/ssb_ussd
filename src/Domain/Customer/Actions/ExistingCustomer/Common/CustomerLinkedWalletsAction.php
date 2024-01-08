<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Common;

use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;

final class CustomerLinkedWalletsAction
{
    public static function execute(Session $session, $session_data): bool
    {
        // Get the linked wallets
        $user_data = json_decode($session->user_data, associative: true);
        $linked_wallets = $user_data['linked_wallets'];

        // Get the wallet
        if (array_key_exists($session_data->user_input, $linked_wallets)) {
            // Update the user inputs (steps)
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['wallet' => $linked_wallets[$session_data->user_input]['wallet'], 'network' => $linked_wallets[$session_data->user_input]['network']]);

            // Return true
            return true;
        }

        // Return false
        return false;
    }
}
