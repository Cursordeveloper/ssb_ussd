<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Payment;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentFrequencyAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['frequency' => $service_data->user_input]);

        // Return the noSususAccount
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
