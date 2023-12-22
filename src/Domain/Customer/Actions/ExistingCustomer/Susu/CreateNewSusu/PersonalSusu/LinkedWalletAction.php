<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the linked wallets
        $user_data = json_decode($session->user_data, associative: true);
        $linked_wallets = $user_data['linked_wallets'];

        // Get the wallet
        if (! array_key_exists($session_data->user_input, $linked_wallets)) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['wallet' => $linked_wallets[$session_data->user_input]['wallet'], 'network' => $linked_wallets[$session_data->user_input]['network']]);

        // Return the confirmTermsConditionsMenu
        return CreatePersonalSusuMenu::narrationMenu(session: $session);
    }
}
