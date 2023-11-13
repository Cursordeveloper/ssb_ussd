<?php

namespace App\States\Welcome;

use App\Menus\Welcome\WelcomeMenu;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Action\SessionCreateAction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WelcomeState
{
    public static function execute(Request $request): JsonResponse {
        // Get the customer
        $customer = GetCustomerAction::execute(phone(data_get(target: $request, key: 'Mobile')));

        // Customer exist and status is active
        if (!$customer == null && data_get(target: $customer, key: 'status') === 'active') {
            // Create new session
            SessionCreateAction::execute(request: $request, state: 'ExistingCustomerState');

            // Return the registered customer menu
            return WelcomeMenu::existingCustomer(data_get(target: $request, key: 'SessionId'));
        }

        // Return the registration menu
        SessionCreateAction::execute(request: $request, state: 'NewCustomerState');
        return WelcomeMenu::newCustomer(data_get(target: $request, key: 'SessionId'));
    }
}
