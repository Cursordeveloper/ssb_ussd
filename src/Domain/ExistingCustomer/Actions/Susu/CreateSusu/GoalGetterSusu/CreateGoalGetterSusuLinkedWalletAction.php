<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\GoalGetterSusu\CreateGoalGetterSusuMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuLinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the linked_wallets
        $linked_wallets = json_decode($session->user_data, associative: true)['linked_wallets'];

        // Return invalid response if linked wallet is not in $linked_wallets array
        if (! array_key_exists(key: $session_data->user_input, array: $linked_wallets)) {
            return CreateGoalGetterSusuMenu::linkedWalletMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['linked_wallet' => $linked_wallets[$session_data->user_input]['resource_id']]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
