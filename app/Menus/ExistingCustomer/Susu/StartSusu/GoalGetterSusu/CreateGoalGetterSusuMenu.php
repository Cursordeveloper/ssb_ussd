<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\StartSusu\GoalGetterSusu;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Domain\ExistingCustomer\Actions\Common\GetSusuDurationsAction;
use Domain\ExistingCustomer\Actions\Common\GetSusuFrequenciesAction;
use Domain\ExistingCustomer\Actions\Common\GetSusuStartDatesAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute the CreateGoalGetterSusu resources
        (new GetSusuDurationsAction)::execute(session: $session);
        (new GetSusuStartDatesAction)::execute(session: $session);
        (new GetSusuFrequenciesAction)::execute(session: $session);

        // Return the mainMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your goal?',
            session_id: $session->session_id,
        );
    }

    public static function targetAmountMenu($session): JsonResponse
    {
        // Return the targetAmountMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your target amount?',
            session_id: $session->session_id,
        );
    }

    public static function durationMenu($session): JsonResponse
    {
        // Get the durations from the session->user_data
        $durations = json_decode($session->user_data, associative: true);

        // Return the durationMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose duration\n".SusuResources::formatDurationsForMenu(durations: $durations['durations']),
            session_id: $session->session_id,
        );
    }

    public static function invalidDurationMenu($session): JsonResponse
    {
        // Get the durations from the session->user_data
        $durations = json_decode($session->user_data, associative: true);

        // Return the invalidDurationMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid duration\n".SusuResources::formatDurationsForMenu(durations: $durations['durations']),
            session_id: $session->session_id,
        );
    }

    public static function startDateMenu($session): JsonResponse
    {
        // Get the durations from the session->user_data
        $start_dates = json_decode($session->user_data, associative: true);

        // Return the startDateMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Start from\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function invalidStartDateMenu($session): JsonResponse
    {
        // Get the start_dates from the session->user_data
        $start_dates = json_decode($session->user_data, associative: true);

        // Return the invalidStartDateMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function frequencyMenu($session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        // Return the frequencyMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose debit frequency\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
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

    public static function narrationMenu(Session $session, array $susu_data, array $linked_account, array $duration): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Goal: '.$susu_data['account_name'].'. Target: GHS'.$susu_data['target_amount'].'. Duration: '.$duration['name'].'. Frequency: '.$susu_data['frequency'].'. Debit: GHS'.$susu_data['susu_amount'].'. Wallet '.$linked_account['account_number'].'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
