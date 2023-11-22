<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\Hubtel\HubtelUssdService;
use App\States\StateManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UssdController extends Controller
{
    public function __invoke(Request $request): JsonResponse {
        $ussd_service = new HubtelUssdService($request);
        return StateManager::execute($ussd_service);
    }
}
