<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\StartSusu\GoalGetterSusu;

use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Domain\ExistingCustomer\Actions\Common\GetDurationsAction;
use Domain\ExistingCustomer\Actions\Common\GetFrequenciesAction;
use Domain\ExistingCustomer\Actions\Common\GetStartDatesAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute the
        (new GetDurationsAction)::execute(session: $session);
        (new GetStartDatesAction)::execute(session: $session);
        (new GetFrequenciesAction)::execute(session: $session);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your goal?',
            session_id: $session->session_id,
        );
    }

    public static function targetAmountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your target amount?',
            session_id: $session->session_id,
        );
    }

    public static function durationMenu($session): JsonResponse
    {
        $durations = json_decode($session->user_data, associative: true);
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n".SusuResources::formatDurationsForMenu(durations: $durations['durations']),
            session_id: $session->session_id,
        );
    }

    public static function invalidDurationMenu($session): JsonResponse
    {
        $durations = json_decode($session->user_data, associative: true);
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid duration\n".SusuResources::formatDurationsForMenu(durations: $durations['durations']),
            session_id: $session->session_id,
        );
    }

    public static function startDateMenu($session): JsonResponse
    {
        $start_dates = json_decode($session->user_data, associative: true);
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Start from\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function invalidStartDateMenu($session): JsonResponse
    {
        $start_dates = json_decode($session->user_data, associative: true);
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
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
            message: 'Goal: '.$susu_data['goal'].', target: GHS'.$susu_data['target_amount'].'. Duration: '.$susu_data['duration'].'. '.$susu_data['frequency'].' debit: GHS'.$susu_data['susu_amount'].' from '.$susu_data['linked_wallet'].'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
