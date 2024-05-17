<?php

declare(strict_types=1);

namespace App\Menus\NewCustomer;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class NewCustomerMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Menu\n1. Register now\n2. About Susubox\n3. Terms & Conditions\n0. Exit",
            session_id: $session->session_id,
        );
    }

    public static function newCustomerInvalidOption($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. Register now\n2. About Susubox\n3. Terms & Conditions\n0. Exit",
            session_id: $session->session_id,
        );
    }
}
