<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States\Statement;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Account\PersonalSusuAccountMenu;
use Domain\Susu\PersonalSusu\States\Account\PersonalSusuAccountState;
use Domain\Susu\Shared\Actions\SusuMiniStatement\SusuMiniStatementAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuMiniStatementState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => self::approvalExecution(session: $session),
            $service_data->user_input === '#' => self::nextStatementExecution(session: $session),
            $service_data->user_input === '0' => self::exitStatementExecution(session: $session, service_data: $service_data),
            default => GeneralMenu::invalidInput(session: $session),
        };
    }

    public static function approvalExecution(Session $session): JsonResponse
    {
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['approval' => true, 'page' => 1]);
        return SusuMiniStatementAction::newTransaction(session: $session, customer: $session->customer, user_inputs: $session->userInputs());
    }

    public static function nextStatementExecution(Session $session): JsonResponse
    {
        return SusuMiniStatementAction::nextTransaction(
            session: $session,
            customer: $session->customer,
            user_inputs: $session->userInputs(),
            page: data_get(target: $session->userInputs(), key: 'page')
        );
    }

    public static function exitStatementExecution(Session $session, $service_data): JsonResponse
    {
        SessionStateUpdateAction::execute(session: $session, state: class_basename(class: PersonalSusuAccountState::class), service_data: $service_data);
        return PersonalSusuAccountMenu::mainMenu(session: $session);
    }
}
