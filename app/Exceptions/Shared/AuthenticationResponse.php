<?php

declare(strict_types=1);

namespace App\Exceptions\Shared;

use App\Common\ResponseBuilder;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class AuthenticationResponse extends Exception
{
    public function report(): JsonResponse
    {
        return ResponseBuilder::resourcesResponseBuilder(
            status: false,
            code: Response::HTTP_UNAUTHORIZED,
            message: 'Request Unauthorised.',
            description: 'You are not authenticated to perform this action.'
        );
    }
}
