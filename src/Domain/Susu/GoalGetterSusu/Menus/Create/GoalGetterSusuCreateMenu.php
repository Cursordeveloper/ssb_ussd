<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Menus\Create;

use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Actions\Common\GetSusuDurationsAction;
use Domain\Susu\Shared\Actions\Common\GetSusuFrequenciesAction;
use Domain\Susu\Shared\Actions\Common\GetSusuStartDatesAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute the CreateGoalGetterSusu resources
        (new GetSusuDurationsAction)::execute(session: $session);
        (new GetSusuStartDatesAction)::execute(session: $session);
        (new GetSusuFrequenciesAction)::execute(session: $session);

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

    public static function initialDepositMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Start with (amount)',
            session_id: $session->session_id,
        );
    }

    public static function startDateMenu($session): JsonResponse
    {
        // Get the durations from the session->user_data
        $start_dates = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Start from\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function invalidStartDateMenu($session): JsonResponse
    {
        // Get the start_dates from the session->user_data
        $start_dates = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice\n".SusuResources::formatStartDatesForMenu(start_dates: $start_dates['start_dates']),
            session_id: $session->session_id,
        );
    }

    public static function frequencyMenu($session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose debit frequency\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function invalidFrequencyMenu($session): JsonResponse
    {
        // Get the frequencies from the session->user_data
        $frequencies = json_decode($session->user_data, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n".SusuResources::formatFrequenciesForMenu(start_dates: $frequencies['frequencies']),
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $susu_data, array $linked_account, array $duration): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Goal: '.$susu_data['account_name'].'. Target: GHS'.$susu_data['target_amount'].'. Duration: '.$duration['name'].'. Frequency: '.$susu_data['frequency'].'. Debit: GHS'.$susu_data['susu_amount'].'. Wallet '.$linked_account['account_number'].'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
