<?php

declare(strict_types=1);

namespace App\Exceptions\Shared;

use App\Common\ResponseBuilder;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RelationNotFoundResponse extends Exception
{
    public function report(): JsonResponse
    {
        return ResponseBuilder::resourcesResponseBuilder(
            status: false,
            code: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: 'Request undefined.',
            description: 'The resources has undefined relationship.'
        );
    }
}
