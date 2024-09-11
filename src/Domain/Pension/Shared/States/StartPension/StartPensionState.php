<?php

declare(strict_types=1);

namespace Domain\Pension\Shared\States\StartPension;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartPensionState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
