<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\LinkedWallet;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyAccount\LinkedWallet\LinkNewWalletMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletNetworkAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate inputs and update the database
        return match (true) {
            ! array_key_exists(key: $service_data->user_input, array: $session->userData()['linked_account_schemes']) => LinkNewWalletMenu::invalidMainMenu(session: $session),

            default => self::schemeStore(session: $session, service_data: $service_data),
        };
    }

    public static function schemeStore(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['scheme_resource_id' => $session->userData()['linked_account_schemes'][$service_data->user_input]['resource_id']]);

        // Return the enterNumberMenu
        return LinkNewWalletMenu::enterNumberMenu(session: $session);
    }
}
