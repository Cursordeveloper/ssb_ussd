<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Authentication;

use App\Common\ResponseBuilder;
use App\Http\Resources\V1\Customer\Authentication\AuthenticationResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class LoginAction
{
    public function execute(array $data): JsonResponse
    {
        // Attempt login
        $token = auth()->guard(
            name: 'customer'
        )->attempt(
            data_get(
                target: $data,
                key: 'data.attributes'
            )
        );

        // Login status conditional
        if (! $token) {
            return ResponseBuilder::resourcesResponseBuilder(
                status: false,
                code: Response::HTTP_UNAUTHORIZED,
                message: 'Authentication failed.',
                description: 'Incorrect email or password.',
            );
        }

        // Return loin successful authentication
        return ResponseBuilder::tokenResponseBuilder(
            status: true,
            code: Response::HTTP_OK,
            message: 'Login successful.',
            token: $this->respondWithToken($token)->original,
            user: new AuthenticationResource(
                auth()->guard(
                    name: 'customer'
                )->user()
            ),
        );
    }

    // Generate bearer token
    protected function respondWithToken(
        $token
    ): JsonResponse {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth(
                guard: 'customer',
            )->factory(null)->getTTL(null) * 120,
        ]);
    }
}
