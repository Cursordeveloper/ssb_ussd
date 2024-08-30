<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Common;

use App\Common\CustomerServiceResources;
use App\Common\Helpers;
use App\Services\Customer\Requests\LinkedAccount\LinkedAccountsRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;

final class GetLinkedAccountSchemesAction
{
    public static function execute(Session $session): void
    {
        // Execute the LinkedAccountsRequest
        $linked_account_schemes = (new LinkedAccountsRequest)->execute();

        // Reformat the durations and (updateUserData) with the wallets data
        SessionInputUpdateAction::updateUserData(session: $session, user_data: [
            'linked_account_schemes' => Helpers::arrayIndex(CustomerServiceResources::formatLinkedAccountSchemesInArray($linked_account_schemes['data'])),
        ]);
    }
}
