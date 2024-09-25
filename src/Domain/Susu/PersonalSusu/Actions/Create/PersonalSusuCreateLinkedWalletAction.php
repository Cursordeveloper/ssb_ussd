<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateLinkedWalletAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user_input and execute the state
        return match (true) {
            ! array_key_exists(key: $service_data->user_input, array: $session->userData()['linked_wallets']) => GeneralMenu::invalidLinkedWalletMenu(session: $session),

            default => self::stateExecution(session: $session, service_data: $service_data, linked_wallets: $session->userData()['linked_wallets'])
        };
    }

    public static function stateExecution(Session $session, $service_data, $linked_wallets): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['linked_wallet' => $linked_wallets[$service_data->user_input]['resource_id']]);

        // Return the rollOverDebitMenu
        return GeneralMenu::rollOverDebitMenu(session: $session);
    }
}
