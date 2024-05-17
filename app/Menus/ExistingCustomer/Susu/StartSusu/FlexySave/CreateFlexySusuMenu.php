<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\StartSusu\FlexySave;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Domain\ExistingCustomer\Actions\Common\GetFrequenciesAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateFlexySusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        (new GetFrequenciesAction)::execute(session: $session);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter account name',
            session_id: $session->session_id,
        );
    }

    public static function debitFrom($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter starting amount range',
            session_id: $session->session_id,
        );
    }

    public static function debitTo($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter ending amount range',
            session_id: $session->session_id,
        );
    }

    public static function frequencyMenu($session): JsonResponse
    {
        $frequencies = json_decode($session->user_data, associative: true);
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose debit frequency\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function invalidFrequencyMenu($session): JsonResponse
    {
        $frequencies = json_decode($session->user_data, associative: true);
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid frequency\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function enforceStrictDebitMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Enforce strict debit?\n1. Yes\n2. No",
            session_id: $session->session_id,
        );
    }

    public static function linkedWalletMenu($session): JsonResponse
    {
        $linked_wallets = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n".LinkedWallets::formatLinkedWalletForMenu(linked_wallets: $linked_wallets['linked_wallets']),
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu($session, $susu_data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Flexy account: '.$susu_data['account_name'].'. Debit range: GHS'.$susu_data['min_amount'].' - GHS'.$susu_data['max_amount'].'. Frequency: '.$susu_data['frequency'].'. Wallet: '.$susu_data['linked_wallet'].'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
