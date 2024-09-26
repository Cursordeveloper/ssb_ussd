<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Collection\Summary;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Collection\Summary\BizSusuCollectionSummaryApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCollectionSummaryState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => BizSusuCollectionSummaryApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
