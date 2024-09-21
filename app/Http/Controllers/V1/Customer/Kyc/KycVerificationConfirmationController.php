<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Kyc;

use App\Http\Controllers\Controller;
use Domain\User\Customer\Actions\MyAccount\Kyc\KycVerificationConfirmationAction;
use Domain\User\Customer\Models\Customer;
use Illuminate\Http\Request;

final class KycVerificationConfirmationController extends Controller
{
    public function __invoke(Customer $customer, Request $request): void
    {
        // Execute the KycVerificationConfirmationAction
        KycVerificationConfirmationAction::execute(customer: $customer, request: $request->all());
    }
}
