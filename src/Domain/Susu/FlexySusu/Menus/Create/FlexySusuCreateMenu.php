<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Menus\Create;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Actions\Common\GetSusuFrequenciesAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Execute the CreateFlexySusu resources
        GetSusuFrequenciesAction::execute(session: $session);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter account name',
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $susu_data, array $linked_account): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Account name: '.$susu_data['account_name'].'. Susu amount: GHS'.$susu_data['susu_amount'].'. Frequency: '.$susu_data['frequency'].'. Wallet: '.$linked_account['account_number'].'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
