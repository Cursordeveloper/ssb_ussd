<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Create\PersonalSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateLinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the linked wallets
        $linked_wallets = json_decode($session->user_data, associative: true)['linked_wallets'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $linked_wallets)) {
            return PersonalSusuCreateMenu::linkedWalletMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['linked_wallet' => $linked_wallets[$session_data->user_input]['resource_id']]);

        // Return the rollOverDebitMenu
        return GeneralMenu::rollOverDebitMenu(session: $session);
    }
}
