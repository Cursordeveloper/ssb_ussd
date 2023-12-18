<?php

namespace App\Http\Controllers\V1;

use App\Common\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Services\Hubtel\HubtelUssdService;
use App\States\StateManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UssdController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Create new instance of the ussd service (HubtelUssdService)
        $session_data = new HubtelUssdService($request);

        // Define numbers to be allowed (Testing purposes)
        $permitted = ['0244294960', '233244294960', '0242662430', '233242662430', '0246936458', '233246936458'];
        if (! in_array($session_data->msisdn, $permitted)) {
            return ResponseBuilder::terminateResponseBuilder(session_id: $session_data->session_id);
        }

        // Return the response
        return StateManager::execute($session_data);
    }
}
