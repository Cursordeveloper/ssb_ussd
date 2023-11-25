<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Common\ResponseBuilder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class Handler extends ExceptionHandler
{
    protected $levels = [
    ];

    protected $dontReport = [
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, $e): JsonResponse
    {
        $exceptions = [
            ThrottleRequestsException::class => [Response::HTTP_TOO_MANY_REQUESTS, 'Request terminated.', 'You have made too many requests.'],
            ModelNotFoundException::class => [$request->wantsJson() ? Response::HTTP_NOT_FOUND : null, 'Request not found', 'The resource does not exist.'],
            NotFoundHttpException::class => [Response::HTTP_NOT_FOUND, 'Request not found.', 'The endpoint does not exist.'],
            MethodNotAllowedHttpException::class => [Response::HTTP_METHOD_NOT_ALLOWED, 'Request not allowed', 'You are not allowed to perform this action.'],
            QueryException::class => [Response::HTTP_UNAUTHORIZED, 'Request is invalid.', $e->getMessage()],
            RelationNotFoundException::class => [Response::HTTP_INTERNAL_SERVER_ERROR, 'Request undefined.', 'The resource has an undefined relationship.'],
            AuthenticationException::class => [Response::HTTP_UNAUTHORIZED, 'Request Unauthorised.', 'You are not authenticated to perform this action.'],
            AuthorizationException::class => [Response::HTTP_FORBIDDEN, 'Request forbidden.', 'You are forbidden to perform this action.'],
            AccessDeniedHttpException::class => [Response::HTTP_FORBIDDEN, 'Request Unauthorised.', 'You do not have access to perform this action.'],
        ];

        foreach ($exceptions as $exceptionType => $responseDetails) {
            if ($e instanceof $exceptionType) {
                [$code, $message, $description] = $responseDetails;
                return ResponseBuilder::resourcesResponseBuilder(
                    status: false,
                    code: $code,
                    message: $message,
                    description: $description,
                );
            }
        }

        return parent::render($request, $e);
    }

    public function register(): void
    {
        $this->reportable(static function (Throwable $e): void {
        });

//        $this->reportable(function (MethodNotAllowedHttpException $e): void {});
//        $this->reportable(function (): void {});
    }
}
