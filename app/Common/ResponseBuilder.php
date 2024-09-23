<?php

declare(strict_types=1);

namespace App\Common;

use Illuminate\Http\JsonResponse;

final class ResponseBuilder
{
    public static function resourcesResponseBuilder(bool $status, int $code, string $message, ?string $description = null, mixed $data = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'description' => $description,
            'meta' => ['version' => '1.0'],
            'data' => $data,
        ]);
    }

    public static function ussdResourcesResponseBuilder(string $message, string $session_id): JsonResponse
    {
        return response()->json([
            'Type' => 'response',
            'SessionId' => $session_id,
            'Message' => $message,
            'DataType' => 'input',
            'FieldType' => 'text',
        ]);
    }

    public static function infoResponseBuilder(string $message, string $session_id): JsonResponse
    {
        return response()->json([
            'Type' => 'release',
            'SessionId' => $session_id,
            'Message' => $message,
        ]);
    }
}
