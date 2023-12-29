<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\MyAccount\LinkedWallets;

use App\Common\Helpers;
use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletsMenu
{
    public static function linkedWalletCollectionMenu($session, $wallets): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Linked Wallets\n".Helpers::formatLinkedWallets(data_get(target: $wallets, key: 'data')).'0. Back',
            session_id: $session->session_id,
        );
    }

    public static function noLinkedWalletMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You have not linked any wallet to your susubox account.\n0. Back",
            session_id: $session->session_id,
        );
    }
}
