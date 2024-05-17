<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\FlexySave\CreateFlexySusuMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FrequencyAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the linked wallets
        $user_data = json_decode($session->user_data, associative: true);
        $frequencies = $user_data['frequencies'];

        // Check if user_input is in the $frequencies array
        if (! array_key_exists(key: $session_data->user_input, array: $frequencies)) {
            // return the invalid frequencyMenu
            return CreateFlexySusuMenu::invalidFrequencyMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['frequency' => $frequencies[$session_data->user_input]['code']]);

        // Return the enterSusuAmountMenu
        return CreateFlexySusuMenu::enforceStrictDebitMenu(session: $session);
    }
}
