<?php

declare(strict_types=1);

namespace App\States\TermsAndConditions;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsState
{
    public static function execute(
        Session $session,
        Request $request,
    ): JsonResponse {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'This is the TermsAndConditions state.',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
