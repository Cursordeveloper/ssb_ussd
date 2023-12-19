<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\MyAccount\LinkNewWallet;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewAccountMenu
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
            message: 'Enter susubox pin',
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\nSelect network\n1. MTN\n2. Airteltigo\n3. Vodafone",
            session_id: $session->session_id,
        );
    }
}
