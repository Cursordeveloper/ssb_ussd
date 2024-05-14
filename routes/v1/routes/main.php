<?php

declare(strict_types=1);

use App\Http\Controllers\V1\UssdController;
use Illuminate\Support\Facades\Route;

Route::group([], function (): void {
    // Main entry route
    Route::post(
        uri: 'main',
        action: UssdController::class
    )->name(name: 'main');
});
