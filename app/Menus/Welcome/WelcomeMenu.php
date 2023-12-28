<?php

declare(strict_types=1);

namespace App\Menus\Welcome;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WelcomeMenu
{
    public static function newCustomer($session): JsonResponse
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

    public static function existingCustomer($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Menu\n1. Susu Savings\n2. Loans\n3. Investments\n4. Insurance\n5. My Account",
            session_id: $session->session_id,
        );
    }

    public static function existingCustomerInvalidOption($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nMenu\n1. Susu Savings\n2. Loans\n3. Investments\n4. Insurance\n5. My Account",
            session_id: $session->session_id,
        );
    }
}
