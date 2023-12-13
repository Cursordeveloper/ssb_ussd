<?php

declare(strict_types=1);

namespace App\States\Account;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\LinkNewAccount\StepFountAction;
use Domain\Customer\Actions\LinkNewAccount\StepOneAction;
use Domain\Customer\Actions\LinkNewAccount\StepThreeAction;
use Domain\Customer\Actions\LinkNewAccount\StepTwoAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // TODO: Step 1 - Check if customer has exceeded the add wallet count
        $steps = json_decode(json: $session->user_inputs, associative: true);

        if (! array_key_exists(key: 'step1', array: $steps)) {
            return StepOneAction::execute(session: $session, session_data: $session_data);
        } elseif (! array_key_exists(key: 'step2', array: $steps)) {
            return StepTwoAction::execute(session: $session, session_data: $session_data);
        } elseif (! array_key_exists(key: 'step3', array: $steps)) {
            return StepThreeAction::execute(session: $session, session_data: $session_data, steps_data: $steps);
        } elseif (! array_key_exists(key: 'step4', array: $steps)) {
            return StepFountAction::execute(session: $session, session_data: $session_data, steps_data: $steps);
        }

        return GeneralMenu::infoNotification(message: 'There was a problem. Try again later.', session: $session);
    }
}
