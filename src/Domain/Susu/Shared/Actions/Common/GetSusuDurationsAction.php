<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\Common;

use App\Common\Helpers;
use App\Common\SusuResources;
use App\Services\Susu\Requests\Susu\Resources\SusuDurationsRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;

final class GetSusuDurationsAction
{
    public static function execute(Session $session): void
    {
        // Execute the SusuDurationsRequest
        $durations = (new SusuDurationsRequest)->execute();

        // Reformat the durations and (updateUserData) with the wallets data
        SessionInputUpdateAction::updateUserData(session: $session, user_data: [
            'durations' => Helpers::arrayIndex(SusuResources::formatDurationsInArray($durations['data'])),
        ]);
    }
}
