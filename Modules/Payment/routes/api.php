<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\App\Http\Controllers\API\PaymentController;
Route::middleware(['auth:api'])->prefix('v1')->group(function () {
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments',  [PaymentController::class, 'index']);
});
