<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\Common;

use App\Common\Helpers;
use App\Common\SusuResources;
use App\Services\Susu\Requests\Susu\Resources\SusuStartDatesRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;

final class GetSusuStartDatesAction
{
    public static function execute(Session $session): void
    {
        // Execute the SusuStartDatesRequest
        $start_dates = (new SusuStartDatesRequest)->execute();

        // Reformat the start_dates and (updateUserData) with the wallets data
        SessionInputUpdateAction::updateUserData(session: $session, user_data: [
            'start_dates' => Helpers::arrayIndex(SusuResources::formatStartDatesInArray($start_dates['data'])),
        ]);
    }
}
