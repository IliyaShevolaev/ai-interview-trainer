<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\Interview\AskController;
use App\Http\Controllers\Interview\CreateInterviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', [ApiController::class, 'index']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::post('/ask', [AskController::class, 'ask']);

Route::group(['prefix' => 'interview'], function() {
    Route::post('/store', [CreateInterviewController::class, 'store'])->middleware('auth:sanctum');
});