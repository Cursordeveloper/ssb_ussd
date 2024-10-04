<?php

declare(strict_types=1);

namespace Domain\Shared\Action\AboutSusuBox;

use App\Common\PolicyText;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\AboutSusuBox\AboutSusuboxMenu;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuBoxAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        //
        $content = PolicyText::aboutSusuBox(session: $session);

        return match (true) {
            empty($content) => GeneralMenu::terminateSession(session: $session),

            default => self::nextText(session: $session, content: $content),
        };
    }

    public static function nextText(Session $session, string $content): JsonResponse
    {
        // Update the user_inputs (page)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['page' => (int) $session->userInputs()['page'] + 1]);

        return AboutSusuboxMenu::nextTextMenu(session: $session, content: $content);
    }
}
