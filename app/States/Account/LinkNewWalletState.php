<?php

declare(strict_types=1);

namespace App\States\Account;

use App\Menus\Account\LinkNewAccount\LinkNewAccountMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // TODO: Step 1 - Check if customer has exceeded the add wallet count

        $steps = json_decode(json: $session->user_inputs, associative: true);

        // TODO: Step 2 - Return the (Select network prompt)
        if (! array_key_exists(key: 'step1', array: $steps)) {
            SessionInputUpdateAction::execute(session: $session, user_input: ['step1' => 'select_network']);
            return LinkNewAccountMenu::selectNetworkMenu(session: $session);
        }

        elseif (! array_key_exists(key: 'step2', array: $steps)) {
            // TODO: Step 3 - Get the selected network, store
            $networks = ['1' => 'mtn', '2' => 'airteltigo', '3' => 'vodafone'];
            SessionInputUpdateAction::execute(session: $session, user_input: ['step2' => $networks[$session_data->user_input]]);

            // TODO: Step 4 - Return the (Enter mobile money number) prompt
            return LinkNewAccountMenu::enterNumberMenu(session: $session);
        }

        elseif (! array_key_exists(key: 'step3', array: $steps)) {
            // TODO: Step 5 - Get the mobile money number and send it to ssb_customer service
            SessionInputUpdateAction::execute(session: $session, user_input: ['step3' => $session_data->user_input]);

            // TODO: Step 6 - Return the (Enter susubox pin) prompt
            return LinkNewAccountMenu::enterPinMenu(session: $session);
        }

        elseif (! array_key_exists(key: 'step4', array: $steps)) {
            // TODO: Step 7 - Get the pin and send it to ssb_customer for authorisation
            SessionInputUpdateAction::execute(session: $session, user_input: ['step5' => 'pin_entered']);

            // TODO: Step 8 - Return process response and terminate the session
            return GeneralMenu::infoNotification(message: 'Successful: You will receive confirmation shortly.', session: $session->session_id,);
        }








        return LinkNewAccountMenu::selectNetworkMenu(session: $session);
    }
}
