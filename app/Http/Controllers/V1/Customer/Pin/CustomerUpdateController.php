<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Customer\Pin;

use App\Http\Controllers\Controller;
use Domain\Customer\Actions\Pin\CustomerUpdateAction;
use Illuminate\Http\Request;

final class CustomerUpdateController extends Controller
{
    public function __invoke(Request $request): void
    {
        // Execute the CreatePinAction
        CustomerUpdateAction::execute(data: $request->all());
    }
}
