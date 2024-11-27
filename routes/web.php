<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api'], function ($router) {
    Route::post('/testone', [TestController::class, 'testOne']);
    // Route::post( '/login', [AuthController::class, 'login'] );
});
