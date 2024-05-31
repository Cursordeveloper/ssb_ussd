<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\StartSusu\FlexySave;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Domain\ExistingCustomer\Actions\Common\GetSusuFrequenciesAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateFlexySusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute the CreateFlexySusu resources
        GetSusuFrequenciesAction::execute(session: $session);

        // Return the mainMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter account name',
            session_id: $session->session_id,
        );
    }

    public static function debitFrom($session): JsonResponse
    {
        // Return the debitFrom
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter starting amount',
            session_id: $session->session_id,
        );
    }

    public static function debitTo($session): JsonResponse
    {
        // Return the debitTo
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter ending amount',
            session_id: $session->session_id,
        );
    }

    public static function frequencyMenu($session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        // Return the frequencyMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose frequency\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function invalidFrequencyMenu($session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        // Return the invalidFrequencyMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid frequency\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function linkedWalletMenu($session): JsonResponse
    {
        // Get the linked_wallets from the session->user_data
        $linked_wallets = json_decode($session->user_data, associative: true);

        // Return the linkedWalletMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n".LinkedWallets::formatLinkedWalletForMenu(linked_wallets: $linked_wallets['linked_wallets']),
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu($session, $susu_data): JsonResponse
    {
        // Return the narrationMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Account name: '.$susu_data['account_name'].'. Debit between: GHS'.$susu_data['min_amount'].' and GHS'.$susu_data['max_amount'].'. Frequency: '.$susu_data['frequency'].'. Wallet: '.$susu_data['linked_wallet'].'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
