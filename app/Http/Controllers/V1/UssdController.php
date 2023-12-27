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
        $permitted = ['0244294960', '233244294960', '0242662430', '233242662430', '0246936458', '233246936458', '0262304009', '233262304009', '0246807930', '233246807930'];

        // Terminate the session for the customer is not permitted to test
        if (! in_array($session_data->msisdn, $permitted)) {
            return ResponseBuilder::infoResponseBuilder(message: 'Your request is being processed. You will receive a notification to confirm status', session_id: $session_data->session_id);
        }

        // Return the response
        return StateManager::execute($session_data);
    }
}
