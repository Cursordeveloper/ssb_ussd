<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions;

use App\Common\Helpers;
use App\Common\SusuResources;
use App\Services\Susu\Requests\Susu\Resources\SusuFrequenciesRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;

final class GetSusuFrequenciesAction
{
    public static function execute(Session $session): void
    {
        // Execute the SusuFrequenciesRequest
        $start_dates = (new SusuFrequenciesRequest)->execute();

        // Reformat the frequencies and (updateUserData) with the wallets data
        SessionInputUpdateAction::updateUserData(session: $session, user_data: [
            'frequencies' => Helpers::arrayIndex(SusuResources::formatFrequenciesInArray($start_dates['data'])),
        ]);
    }
}
