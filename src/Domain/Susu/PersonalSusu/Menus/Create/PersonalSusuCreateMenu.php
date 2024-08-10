<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Create;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Return the mainMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter account name',
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
            message: 'Account name: '.$susu_data['account_name'].'. Amount: GHS'.$susu_data['susu_amount'].'. Frequency: daily. Wallet: '.$linked_account['account_number'].'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
