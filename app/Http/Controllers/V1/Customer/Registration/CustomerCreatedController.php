<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Registration;

use App\Http\Controllers\Controller;
use Domain\NewCustomer\Jobs\Registration\CustomerCreatedJob;
use Illuminate\Http\Request;

final class CustomerCreatedController extends Controller
{
    public function __invoke(Request $request): void
    {
        // Dispatch the CustomerCreatedJob
        CustomerCreatedJob::dispatch($request->all());
    }
}
