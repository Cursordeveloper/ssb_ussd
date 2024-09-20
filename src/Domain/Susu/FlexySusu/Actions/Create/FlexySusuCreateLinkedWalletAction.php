<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateLinkedWalletAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the linked wallets
        $linked_wallets = json_decode($session->user_data, associative: true)['linked_wallets'];

        // Validate the user_input (susu_amount)
        return match (true) {
            ! array_key_exists(key: $service_data->user_input, array: $linked_wallets) => GeneralMenu::invalidLinkedWalletMenu(session: $session),

            default => self::linkedWalletStore(session: $session, service_data: $service_data, linked_wallets: $linked_wallets)
        };
    }

    public static function linkedWalletStore(Session $session, $service_data, $linked_wallets): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['linked_wallet' => $linked_wallets[$service_data->user_input]['resource_id']]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
