<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\MyAccount\LinkedWallet;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\MyAccount\LinkedWallet\LinkedWalletsAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletsMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Execute the LinkedWalletsAction
        return LinkedWalletsAction::execute(session: $session);
    }

    public static function linkedWalletCollectionMenu(Session $session, array $wallets): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Linked Wallets\n".LinkedWallets::formatLinkedWalletCollection(data_get(target: $wallets, key: 'data')).'0. Back',
            session_id: $session->session_id,
        );
    }

    public static function invalidLinkedWalletCollectionMenu(Session $session, array $wallets): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n".LinkedWallets::formatLinkedWallets(linked_wallets: $wallets).'0. Back',
            session_id: $session->session_id,
        );
    }

    public static function noLinkedWalletMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'You have not linked any wallet to your SusuBox account.',
            session_id: $session->session_id,
        );
    }
}
