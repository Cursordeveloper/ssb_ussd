<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Customer\Pin\CustomerHasPinUpdateController;
use App\Http\Controllers\V1\Customer\Registration\CustomerCreatedController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'customers', 'as' => 'customers.'], function (): void {
    // Customer create route
    Route::post(
        uri: '',
        action: CustomerCreatedController::class
    )->name(
        name: 'store',
    );

    // Update customer has_pin status route
    Route::put(
        uri: 'registrations/pins',
        action: CustomerHasPinUpdateController::class
    )->name(
        name: 'update',
    );
});
