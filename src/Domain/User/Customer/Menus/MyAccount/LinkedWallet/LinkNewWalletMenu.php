<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\MyAccount\LinkedWallet;

use App\Common\CustomerServiceResources;
use App\Common\ResponseBuilder;
use Domain\Shared\Action\Common\GetLinkedAccountSchemesAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Execute the LinkedAccountSchemes
        GetLinkedAccountSchemesAction::execute(session: $session);

        $linked_account_schemes = json_decode($session->user_data, associative: true);
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Select network\n".CustomerServiceResources::formatLinkedAccountSchemesForMenu(linked_account_schemes: $linked_account_schemes['linked_account_schemes']),
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        $linked_account_schemes = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n".CustomerServiceResources::formatLinkedAccountSchemesForMenu(linked_account_schemes: $linked_account_schemes['linked_account_schemes']),
            session_id: $session->session_id,
        );
    }

    public static function enterNumberMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter mobile money number',
            session_id: $session->session_id,
        );
    }

    public static function noLinkedAccountMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'You have no linked wallet(s). Select option 2 on My Account to link a wallet.',
            session_id: $session->session_id,
        );
    }
}
