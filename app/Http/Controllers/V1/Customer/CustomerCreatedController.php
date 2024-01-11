<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer;

use App\Http\Controllers\Controller;
use Domain\NewCustomer\Actions\Registration\CustomerCreatedAction;
use Illuminate\Http\Request;

final class CustomerCreatedController extends Controller
{
    public function __invoke(Request $request): void
    {
        // Create the customer
        CustomerCreatedAction::execute(data: $request->all());
    }
}
