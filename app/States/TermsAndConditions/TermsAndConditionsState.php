<?php

declare(strict_types=1);

namespace App\States\TermsAndConditions;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsState
{
    public static function execute(
        array $request
    ): JsonResponse {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'This is the TermsAndConditions state.',
            session_id: data_get($request, key: 'SessionId'),
        );
    }
}
