<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Create\FlexySusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateLinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the linked_wallets
        $linked_wallets = json_decode($session->user_data, associative: true)['linked_wallets'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $linked_wallets)) {
            return FlexySusuCreateMenu::linkedWalletMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['linked_wallet' => $linked_wallets[$session_data->user_input]['resource_id']]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
