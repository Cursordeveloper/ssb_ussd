<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\TermsAndConditions;

use App\Common\PolicyText;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Execute the PolicyText and return the policy
        $content = PolicyText::termsAndConditions(session: $session);

        return match (true) {
            empty($content) => GeneralMenu::terminateSession(session: $session),

            default => self::nextText(session: $session, content: $content),
        };
    }

    public static function nextText(Session $session, string $content): JsonResponse
    {
        // Update the user_inputs (page)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['page' => (int) $session->userInputs()['page'] + 1]);

        return GeneralMenu::nextTextMenu(session: $session, content: $content);
    }
}
