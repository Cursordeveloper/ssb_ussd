<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\BizSusu\CreateBizSusuMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateBizSusuFrequencyAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the frequencies from the $session->user_data
        $frequencies = json_decode($session->user_data, associative: true)['frequencies'];

        // Return the invalidFrequencyMenu if user_input is not in $frequencies
        if (! array_key_exists(key: $session_data->user_input, array: $frequencies)) {
            // return the invalid frequencyMenu
            return CreateBizSusuMenu::invalidFrequencyMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['frequency' => $frequencies[$session_data->user_input]['code']]);

        // Return the chooseLinkedWalletMenu
        return CreateBizSusuMenu::linkedWalletMenu(session: $session);
    }
}
