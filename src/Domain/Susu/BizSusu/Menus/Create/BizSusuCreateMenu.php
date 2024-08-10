<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Menus\Create;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Actions\GetSusuFrequenciesAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute the GetFrequencies
        GetSusuFrequenciesAction::execute(session: $session);

        // Return the CreateBizSusu mainMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter business / account name',
            session_id: $session->session_id,
        );
    }

    public static function susuAmountMenu($session): JsonResponse
    {
        // Return the susuAmountMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter susu amount',
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
            message: "Invalid option, try again\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function linkedWalletMenu($session): JsonResponse
    {
        // Get the linked wallets from the session->user_data
        $linked_wallets = json_decode($session->user_data, associative: true);

        // Return the linkedWalletMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n".LinkedWallets::formatLinkedWalletForMenu(linked_wallets: $linked_wallets['linked_wallets']),
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $susu_data, array $linked_account): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Account name: '.$susu_data['business_name'].'. Amount: GHS'.$susu_data['susu_amount'].'. Frequency: '.strtolower($susu_data['frequency']).'. Wallet: '.$linked_account['account_number'].'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
