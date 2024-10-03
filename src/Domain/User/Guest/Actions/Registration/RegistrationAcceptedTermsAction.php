<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Guest\Jobs\Registration\CustomerRegistrationJob;
use Domain\User\Guest\Menus\Registration\RegistrationMenu;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationAcceptedTermsAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            $service_data->user_input === '1' => self::actionExecution(session: $session),
            $service_data->user_input === '2' => GeneralMenu::processCancelNotification(session: $session),

            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    public static function actionExecution(Session $session): JsonResponse
    {
        try {
            $customer = CustomerCreateAction::execute(session: $session);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true]);
            $session->update(['customer_id' => $customer->id]);
            CustomerRegistrationJob::dispatch($customer->refresh());

            return RegistrationMenu::choosePin(session: $session);
        } catch (Exception $exception) {
            return GeneralMenu::systemErrorNotification(session: $session);
        }
    }
}
