<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\MyAccount\LinkNewWallet;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletMenu
{
    public static function selectNetworkMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Select network\n1. MTN\n2. Airteltigo\n3. Vodafone",
            session_id: $session->session_id,
        );
    }

    public static function enterNumberMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter mobile money number',
            session_id: $session->session_id,
        );
    }

    public static function enterPinMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter Susubox pin',
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nSelect network\n1. MTN\n2. Airteltigo\n3. Vodafone",
            session_id: $session->session_id,
        );
    }

    public static function linkedAccountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You have no linked wallet(s). Link a wallet now? \n1. Yes\n2. No",
            session_id: $session->session_id,
        );
    }
}
