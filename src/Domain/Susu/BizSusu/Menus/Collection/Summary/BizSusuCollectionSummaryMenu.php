<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Menus\Collection\Summary;

use App\Common\ResponseBuilder;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCollectionSummaryMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return GeneralMenu::pinMenu(session: $session);
    }

    public static function narrationMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Successful Transactions: '.data_get(target: $session->userInputs(), key: 'susu_account.included.stats.collection.attributes.total_successful').'. Failed Transactions: '.data_get(target: $session->userInputs(), key: 'susu_account.included.stats.collection.attributes.total_unsuccessful').'. Successful payments: '.data_get(target: $session->userInputs(), key: 'susu_account.included.stats.payment.attributes.total_failed').'. Failed payments: '.data_get(target: $session->userInputs(), key: 'susu_account.included.stats.settlement.attributes.total_settlements').'. Successful Withdrawals: '.data_get(target: $session->userInputs(), key: 'susu_account.included.stats.withdrawal.attributes.total_successful').'. Failed Withdrawals: '.data_get(target: $session->userInputs(), key: 'susu_account.included.stats.withdrawal.attributes.total_unsuccessful'),
            session_id: $session->session_id,
        );
    }
}
