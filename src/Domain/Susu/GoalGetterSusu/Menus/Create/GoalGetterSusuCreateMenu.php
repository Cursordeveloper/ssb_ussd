<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Menus\Create;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Actions\Common\GetSusuDurationsAction;
use Domain\Susu\Shared\Actions\Common\GetSusuFrequenciesAction;
use Domain\Susu\Shared\Actions\Common\GetSusuStartDatesAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateMenu
{
    public static function mainMenu(Session $session): JsonResponse
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

    public static function targetAmountMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your target amount?',
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $susu_data, array $linked_account, array $duration): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Goal: '.$susu_data['account_name'].'. Target: GHS'.$susu_data['target_amount'].'. Duration: '.$duration['name'].'. Frequency: '.$susu_data['frequency'].'. Debit: GHS'.$susu_data['susu_amount'].'. Wallet '.$linked_account['account_number'].'. Enter PIN to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
