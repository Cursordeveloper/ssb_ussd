<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\Common;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateSusuRolloverAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define the options array
        $options = ['1', '2'];

        // Return the invalidRollOverDebitMenu menu if user_input is not 1
        if (! in_array($service_data->user_input, $options)) {
            return GeneralMenu::invalidRollOverDebitMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['rollover' => $service_data->user_input === '1']);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
