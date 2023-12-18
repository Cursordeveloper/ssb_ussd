<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu;

use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
