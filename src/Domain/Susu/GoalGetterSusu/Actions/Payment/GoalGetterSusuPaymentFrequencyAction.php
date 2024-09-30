<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Payment;

use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentFrequencyAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            SusuValidationAction::isNumericValid($service_data->user_input) === false => SusuValidationMenu::isNumericMenu(session: $session),

            default => self::actionExecution(session: $session, service_data: $service_data)
        };
    }

    private static function actionExecution(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['frequency' => $service_data->user_input]);

        // Return the noSususAccount
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
