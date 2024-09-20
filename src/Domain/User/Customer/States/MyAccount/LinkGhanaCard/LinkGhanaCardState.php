<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MyAccount\LinkGhanaCard;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\MyAccount\LinkGhanaCard\LinkGhanaCardApprovalAction;
use Domain\User\Customer\Actions\MyAccount\LinkGhanaCard\LinkGhanaCardIDNumberAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkGhanaCardState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'id_number', array: $session->userInputs()) => LinkGhanaCardIDNumberAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => LinkGhanaCardApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
