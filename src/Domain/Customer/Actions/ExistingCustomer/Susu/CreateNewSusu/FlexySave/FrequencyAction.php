<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FrequencyAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Frequency array
        $frequencies = ['1' => 'Daily', '2' => 'Weekly', '3' => 'Monthly'];

        // Check if user_input is in the $frequencies array
        if (! array_key_exists(key: $session_data->user_input, array: $frequencies)) {
            // return the invalid frequencyMenu
            return CreateFlexySusuMenu::invalidFrequencyMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['frequency' => $frequencies[$session_data->user_input]]);

        // Return the enterSusuAmountMenu
        return CreateFlexySusuMenu::enforceStrictDebitMenu(session: $session);
    }
}
