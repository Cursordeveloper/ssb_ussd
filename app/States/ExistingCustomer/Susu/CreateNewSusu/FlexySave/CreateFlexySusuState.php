<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu\FlexySave;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\AccountNameAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\AccountSummaryAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\ChooseLinkedAccountAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\ChooseSusuSchemeAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\CreateNewSusuAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\PinConfirmationAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\SusuAmountAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\TermsAgreementAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateFlexySusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
