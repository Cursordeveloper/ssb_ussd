<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Pin;

use App\Http\Controllers\Controller;
use Domain\User\Guest\Actions\Registration\CustomerHasPinUpdateAction;
use Illuminate\Http\Request;

final class CustomerHasPinUpdateController extends Controller
{
    public function __invoke(Request $request): void
    {
        // Execute the CustomerHasPinUpdateAction
        CustomerHasPinUpdateAction::execute(data: $request->all());
    }
}
