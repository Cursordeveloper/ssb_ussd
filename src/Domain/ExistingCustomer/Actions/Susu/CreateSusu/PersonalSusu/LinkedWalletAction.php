<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\PersonalSusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\PersonalSusu\CreatePersonalSusuMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the linked wallets
        $user_data = json_decode($session->user_data, associative: true);
        $linked_wallets = $user_data['linked_wallets'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $linked_wallets)) {
            return CreatePersonalSusuMenu::linkedWalletMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['linked_wallet' => $linked_wallets[$session_data->user_input]['resource_id']]);

        // Return system error menu
        return CreatePersonalSusuMenu::acceptedTermsMenu(session: $session);
    }
}
