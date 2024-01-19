<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts;

use App\Common\ResponseBuilder;
use App\Common\SusuAccounts;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\MySusuAccountsAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute MySusuAccountsAction action
        return MySusuAccountsAction::execute(session: $session);
    }

    public static function noSususAccount($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You do not have any active susu account.\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function susuAccountsMenu($session, array $susu_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu Accounts\n".SusuAccounts::formatSusuAccountsForOutput(data_get(target: $susu_data, key: 'data')).'0. Back',
            session_id: $session->session_id,
        );
    }

    public static function invalidSusuAccountsMenu($session, array $susu_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n".SusuAccounts::formatSusuAccounts(susu_accounts: $susu_data).'0. Back',
            session_id: $session->session_id,
        );
    }
}
