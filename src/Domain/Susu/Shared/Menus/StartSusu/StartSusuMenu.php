<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\StartSusu;

use App\Common\Helpers;
use App\Common\LinkedWallets;
use App\Common\ResponseBuilder;
use App\Services\Susu\Requests\Customer\SusuServiceLinkAccountsRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyAccount\LinkedWallet\LinkNewWalletMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartSusuMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Execute and store the SusuServiceLinkAccountsRequest
        $linked_wallets = (new SusuServiceLinkAccountsRequest)->execute(customer: $session->customer);

        return match (true) {
            empty(data_get(target: $linked_wallets, key: 'data')) => LinkNewWalletMenu::noLinkedAccountMenu(session: $session),
            default => self::susuSchemesMenu(session: $session, linked_wallets: $linked_wallets)
        };
    }

    public static function susuSchemesMenu(Session $session, array $linked_wallets): JsonResponse
    {
        // Format the wallets and (updateUserData) with the wallets data
        SessionInputUpdateAction::updateUserData(session: $session, user_data: ['linked_wallets' => Helpers::arrayIndex(LinkedWallets::formatLinkedWalletsInArray($linked_wallets['data']))]);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu Schemes\n1. Personal Susu\n2. Biz Susu\n3. Goal Getter Susu\n4. Flexy Susu",
            session_id: $session->session_id,
        );
    }

    public static function invalidSusuSchemesMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. Personal Susu\n2. Biz Susu\n3. Goal Getter Susu\n4. Flexy Susu",
            session_id: $session->session_id,
        );
    }
}
