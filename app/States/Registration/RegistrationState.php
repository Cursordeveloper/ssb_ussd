<?php

declare(strict_types=1);

namespace App\States\Registration;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationState
{
    public static function execute(
        array $request
    ): JsonResponse {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'This is the Registration state.',
            session_id: data_get($request, key: 'SessionId'),
        );
    }
}
