<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::group(['prefix' => 'test'], function ($router) {
    Route::post('/one', [TestController::class, 'testOne']);
    Route::post('/two', [TestController::class, 'testTwo']);
    Route::post('/three', [TestController::class, 'testThree']);
});
