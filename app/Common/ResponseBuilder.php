<?php

declare(strict_types=1);

namespace App\Common;

use Illuminate\Http\JsonResponse;

final class ResponseBuilder
{
    public static function collectionResponseBuilder(
        bool $status,
        int $code,
        string $message,
        ?string $description = null,
        mixed $data = null
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'description' => $description,
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toDateTime(),
            ],
            'data' => $data->data,
            'data_meta' => $data->meta,
        ]);
    }

    public static function resourcesResponseBuilder(
        bool $status,
        int $code,
        string $message,
        ?string $description = null,
        mixed $data = null
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'description' => $description,
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toDateTime(),
            ],
            'data' => $data,
        ]);
    }

    public static function unprocessableEntityResponseBuilder(
        bool $status,
        int $code,
        string $message,
        ?string $description = null,
        mixed $error = null
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'description' => $description,
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toDateTime(),
            ],
            'errors' => $error,
        ]);
    }

    public static function errorResponseBuilder(
        bool $status,
        int $code,
        string $message,
        ?string $description = null
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'description' => $description,
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toDateTime(),
            ],
        ]);
    }

    public static function tokenResponseBuilder(
        bool $status,
        int $code,
        string $message,
        mixed $token = null,
        mixed $user = null
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toDateTime(),
            ],
            'data' => $user,
            'token' => $token,
        ]);
    }
}
