<?php

declare(strict_types=1);

namespace App\Http\Middleware\IPAddress;

use App\Common\ResponseBuilder;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class IPWhiteListMiddleware
{
    protected array $ips = ['172.18.0.1', '172.21.0.1'];

    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->ip(), $this->ips)) {
            return ResponseBuilder::resourcesResponseBuilder(
                status: false,
                code: Response::HTTP_UNAUTHORIZED,
                message: 'Unauthorised access.',
                description: 'Your ip address is not whitelisted'
            );
        }

        return $next($request);
    }
}
