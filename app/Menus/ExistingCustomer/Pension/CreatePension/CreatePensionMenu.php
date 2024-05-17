<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Pension\CreatePension;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreatePensionMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Dear valued customer, watch out this space.. We got amazing pension products coming soon.',
            session_id: $session->session_id,
        );
    }
}
