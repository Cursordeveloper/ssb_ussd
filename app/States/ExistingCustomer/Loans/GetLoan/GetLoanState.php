<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans\GetLoan;

use App\Menus\ExistingCustomer\Loan\GetLoan\GetLoanMenu;
use App\Menus\ExistingCustomer\MyAccount\LinkKyc\LinkKycMenu;
use Domain\ExistingCustomer\Actions\Common\HasKycAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetLoanState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Terminate session if customer does not have Ghana Card
        if (! HasKycAction::execute(session: $session)) {
            return LinkKycMenu::noKycMenu(session: $session);
        }

        // Define a mapping between customer input and states
        $stateMappings = [
//            '1' => ['class' => new CreatePersonalSusuState, 'menu' => new CreatePersonalSusuMenu],
        ];

        // The customer input is invalid
        return GetLoanMenu::invalidMainMenu(session: $session);
    }
}
