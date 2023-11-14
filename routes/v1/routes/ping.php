<?php

declare(strict_types=1);

use App\Http\Controllers\Shared\Ping\PingController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'ping'], function (): void {
    Route::get(
        uri: '',
        action: PingController::class
    )->name(name: 'ping');
});
