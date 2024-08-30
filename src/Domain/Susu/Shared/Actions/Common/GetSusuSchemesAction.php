<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\Common;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Product\Product;
use Domain\Shared\Models\Session\Session;

final class GetSusuSchemesAction
{
    public static function execute(Session $session, $session_data): void
    {
        // Get all the susu schemes
        $product = Product::where('category', '=', 'susu')->where('order', '=', $session_data->user_input)->first();

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['scheme' => $product['resource_id']]);
    }
}
