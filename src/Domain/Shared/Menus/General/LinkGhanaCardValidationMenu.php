<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\General;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkGhanaCardValidationMenu
{
    public static function isGhanaCardMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The Ghana Card number you entered is invalid. Please correct your input and try again.',
            session_id: $session->session_id,
        );
    }
}
