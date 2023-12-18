<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreatePersonalSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Personal Susu Savings\n\nEnter the account name",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function enterSusuAmountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter the susu amount',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function chooseLinkedWalletMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose linked wallet\n1. 0244294960\n2. 0244637602\n3. 0244294960",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function confirmTermsConditionsMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Accept terms\n1. Yes\n2. No\n3. Terms & Conditions",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function accountSummaryMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Account summary\n1. Account Name: Some Name\n2. Susu Amount: GHS10\n3. Debit Frequency: Daily\n#. Continue",
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
