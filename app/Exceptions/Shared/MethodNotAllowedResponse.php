<?php

declare(strict_types=1);

namespace App\Exceptions\Shared;

use App\Common\ResponseBuilder;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class MethodNotAllowedResponse extends Exception
{
    public function report(string $message): JsonResponse
    {
        return ResponseBuilder::resourcesResponseBuilder(
            status: false,
            code: Response::HTTP_UNAUTHORIZED,
            message: 'Request is invalid.',
            description: $message
        );
    }
}
