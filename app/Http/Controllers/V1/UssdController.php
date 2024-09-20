<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\Hubtel\HubtelUssdService;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Services\StartNewSessionService;
use Domain\Shared\Services\StateManagerService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UssdController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Create new instance of the ussd service (HubtelUssdService)
        $service_data = new HubtelUssdService($request);

        // Define numbers to be allowed (Testing purposes)
        $permitted = ['0244294960', '233244294960', '233242662430', '0246936458', '233246936458', '0262304009', '233262304009', '0246807930', '233246807930'];

        // Terminate the session for the customer is not permitted to test
        return match (true) {
            ! in_array($service_data->msisdn, $permitted) => GeneralMenu::terminateService(session_id: $service_data->session_id),
            $service_data->new_session === true => StartNewSessionService::execute(state_data: $service_data),

            default => StateManagerService::execute(state_data: $service_data),
        };
    }
}
