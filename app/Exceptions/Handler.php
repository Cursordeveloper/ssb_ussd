<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Shared\AccessDeniedHttpResponse;
use App\Exceptions\Shared\AuthenticationResponse;
use App\Exceptions\Shared\AuthorizationResponse;
use App\Exceptions\Shared\MethodNotAllowedResponse;
use App\Exceptions\Shared\ModelNotFoundResponse;
use App\Exceptions\Shared\NotFoundHttpResponse;
use App\Exceptions\Shared\RelationNotFoundResponse;
use App\Exceptions\Shared\ThrottleResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $exceptionResponseMap = [
            ThrottleRequestsException::class => ThrottleResponse::class,
            ModelNotFoundException::class => ModelNotFoundResponse::class,
            NotFoundHttpException::class => NotFoundHttpResponse::class,
            MethodNotAllowedHttpException::class => MethodNotAllowedResponse::class,
            QueryException::class => MethodNotAllowedResponse::class,
            RelationNotFoundException::class => RelationNotFoundResponse::class,
            AuthenticationException::class => AuthenticationResponse::class,
            AuthorizationException::class => AuthorizationResponse::class,
            AccessDeniedHttpException::class => AccessDeniedHttpResponse::class,
        ];
        foreach ($exceptionResponseMap as $exceptionType => $responseClass) {
            if ($e instanceof $exceptionType) {
                throw new $responseClass();
            }
        }
        return parent::render($request, $e);
    }

    public function register(): void
    {
        $this->reportable(function (): void {
        });
    }
}
