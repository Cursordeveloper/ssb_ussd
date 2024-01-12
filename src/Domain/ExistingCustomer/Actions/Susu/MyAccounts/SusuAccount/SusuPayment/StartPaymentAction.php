<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuPayment;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPayment\SusuPaymentMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartPaymentAction
{
    public static function execute(Session $session, array $user_inputs): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['start_payment' => true]);

        // Return the noSususAccount
        return SusuPaymentMenu::frequencyMenu(session: $session, frequency: data_get(target: $user_inputs, key: 'account_frequency'));
    }
}
