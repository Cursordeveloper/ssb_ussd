<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu\FlexySave;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateFlexySusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Flexy Susu Savings\n\nEnter the account name",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function summaryConfirmationMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Account summary\n1. Account Name: Some Name\n2. Susu Amount: GHS10\n3. Debit Frequency: Daily\nEnter your susubox pin",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function pinConfirmationMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter your susubox pin',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
