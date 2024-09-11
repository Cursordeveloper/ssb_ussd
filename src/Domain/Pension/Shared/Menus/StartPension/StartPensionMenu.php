<?php

declare(strict_types=1);

namespace Domain\Pension\Shared\Menus\StartPension;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartPensionMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Dear valued customer, watch out this space.. We got amazing pension products coming soon.',
            session_id: $session->session_id,
        );
    }
}
