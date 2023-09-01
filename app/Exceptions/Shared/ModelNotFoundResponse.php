<?php

declare(strict_types=1);

namespace App\Exceptions\Shared;

use App\Common\ResponseBuilder;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ModelNotFoundResponse extends Exception
{
    public function report(): JsonResponse
    {
        return ResponseBuilder::resourcesResponseBuilder(
            status: false,
            code: Response::HTTP_TOO_MANY_REQUESTS,
            message: 'Request terminated.',
            description: 'You have made too many requests.'
        );
    }
}
