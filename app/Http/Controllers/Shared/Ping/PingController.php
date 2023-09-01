<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shared\Ping;

use App\Common\ResponseBuilder;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PingController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return ResponseBuilder::resourcesResponseBuilder(
            status: true,
            code: Response::HTTP_OK,
            message: 'Service is online.'
        );
    }
}
