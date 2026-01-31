<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\App\Http\Controllers\API\OrderController;

Route::middleware(['auth:api'])->prefix('v1')->group(function () {
    Route::apiResource('orders', OrderController::class)->names('orders');
    Route::put('order-status/{id}', [OrderController::class, 'updateStatus']);
});
