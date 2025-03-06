<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Interview\AskController;
use App\Http\Controllers\API\Auth\CheckAuthController;
use App\Http\Controllers\API\Admin\BugReportController;
use App\Http\Controllers\API\Profile\UserRatesController;
use App\Http\Controllers\API\Tools\RetokennaizeController;
use App\Http\Controllers\API\Interview\InterviewController;
use App\Http\Controllers\API\Profile\GetAIFeedbackController;
use App\Http\Controllers\API\Profile\InterviewManageController;
use App\Http\Controllers\API\Profile\InterviewManageResultController;
use App\Http\Controllers\API\Profile\ModelsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', [ApiController::class, 'index']);

Route::group(['prefix' => 'auth'], function () {
    Route::get('/check', CheckAuthController::class);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::post('/ask', [AskController::class, 'ask']);

Route::group(['prefix' => 'interview'], function() {
    Route::get('/get/{interview}', [InterviewController::class, 'get']);
    Route::post('/store', [InterviewController::class, 'store'])->middleware('auth:sanctum');
    Route::patch('/update', [InterviewController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/rate-answer', [InterviewController::class, 'rate']);
    Route::post('/finish', [InterviewController::class, 'finish']);
    Route::post('/find', [InterviewController::class, 'find']);
});

Route::group(['prefix' => 'profile', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/my-results', [UserRatesController::class, 'index']);
    Route::get('/rate/{interviewResult}', [UserRatesController::class, 'get']);
    Route::get('/interviews-manage', [InterviewManageController::class, 'index']);
    Route::get('/interviews-manage/results/{interview}', [InterviewManageResultController::class, 'index']);
    Route::get('/interviews-manage/user-answers/{interviewResult}', [InterviewManageResultController::class, 'get']);
    Route::get('/modelslist', [ModelsController::class, 'index']);
    Route::post('/setmodel', [ModelsController::class, 'set']);
});

Route::get('/retokenaize-token/{token}', RetokennaizeController::class);

Route::post('/report', [BugReportController::class, 'store']);
Route::get('/feedback/{answer}', [GetAIFeedbackController::class, 'get']);