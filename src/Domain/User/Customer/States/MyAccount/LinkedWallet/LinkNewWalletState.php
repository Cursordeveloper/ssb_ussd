<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MyAccount\LinkedWallet;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\MyAccount\LinkedWallet\LinkNewWalletApprovalAction;
use Domain\User\Customer\Actions\MyAccount\LinkedWallet\LinkNewWalletMobileNumberAction;
use Domain\User\Customer\Actions\MyAccount\LinkedWallet\LinkNewWalletNetworkAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'scheme_resource_id', array: $session->userInputs()) => LinkNewWalletNetworkAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'mobile_number', array: $session->userInputs()) => LinkNewWalletMobileNumberAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => LinkNewWalletApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
