<?php

declare(strict_types=1);

namespace App\Exceptions\Shared;

use App\Common\ResponseBuilder;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class AuthorizationResponse extends Exception
{
    public function report(): JsonResponse
    {
        return ResponseBuilder::resourcesResponseBuilder(
            status: false,
            code: Response::HTTP_FORBIDDEN,
            message: 'Request forbidden.',
            description: 'You are forbidden to perform this action.'
        );
    }
}
