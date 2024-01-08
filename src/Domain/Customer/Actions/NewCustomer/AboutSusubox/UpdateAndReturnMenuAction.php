<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\NewCustomer\AboutSusubox;

use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UpdateAndReturnMenuAction
{
    public static function execute(Session $session, string $key, JsonResponse $menu): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: [$key => true]);

        // Return the menu (Term and Condition)
        return $menu;
    }
}
