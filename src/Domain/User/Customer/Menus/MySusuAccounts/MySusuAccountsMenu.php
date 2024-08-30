<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\MySusuAccounts;

use App\Common\ResponseBuilder;
use App\Common\SusuAccounts;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\User\Customer\Actions\MySusuAccounts\MySusuAccountsAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Reset user_inputs and user_data
        SessionInputUpdateAction::resetAll(session: $session);

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
            message: "My Susu Accounts\n".SusuAccounts::formatSusuAccountsForOutput(data_get(target: $susu_data, key: 'data')).'0. Back',
            session_id: $session->session_id,
        );
    }

    public static function invalidSusuAccountsMenu($session, array $susu_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n".SusuAccounts::formatSusuAccountsForMenu(susu_accounts: $susu_data).'0. Back',
            session_id: $session->session_id,
        );
    }
}
