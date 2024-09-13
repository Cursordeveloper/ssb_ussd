<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Payment;

use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPaymentFrequencyAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            SusuValidationAction::isNumericValid($session_data->user_input) === false => SusuValidationMenu::isNumericMenu(session: $session),

            default => self::initialDepositStore(session: $session, session_data: $session_data)
        };
    }

    public static function initialDepositStore(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['frequency' => $session_data->user_input]);

        // Return the noSususAccount
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
