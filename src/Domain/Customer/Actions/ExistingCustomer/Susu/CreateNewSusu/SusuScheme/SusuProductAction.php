<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\SusuScheme;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Product;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuProductAction
{
    public static function execute(Session $session, $session_data): void
    {
        // Get all the susu schemes
        $product = Product::where('category', '=', 'susu')->where('order', '=', $session_data->user_input)->first();

        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['susuScheme' => $product['name']]);
    }
}
