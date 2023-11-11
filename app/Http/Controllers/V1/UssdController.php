<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\States\StateManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UssdController extends Controller
{
    public function __invoke(
        Request $request,
    ): JsonResponse {
        return StateManager::execute($request);
    }
}
