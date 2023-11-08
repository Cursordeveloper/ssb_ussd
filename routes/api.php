<?php

declare(strict_types=1);

use App\Http\Controllers\V1\UssdController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/ussd')
    ->as('v1.ussd:')
    ->group(base_path('routes/v1/routes.php'));

Route::post(
    uri: 'api/main',
    action: UssdController::class
)->name(name: 'main');

