<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Create\GoalGetterSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateFrequencyAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the frequencies
        $frequencies = json_decode($session->user_data, associative: true)['frequencies'];

        // Return the invalidFrequencyMenu if user_input is not in $frequencies
        if (! array_key_exists(key: $session_data->user_input, array: $frequencies)) {
            return GoalGetterSusuCreateMenu::invalidFrequencyMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['frequency' => $frequencies[$session_data->user_input]['code']]);

        // Return the chooseLinkedWalletMenu
        return GoalGetterSusuCreateMenu::linkedWalletMenu(session: $session);
    }
}
