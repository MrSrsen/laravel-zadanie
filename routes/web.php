<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/api'], function () {
    Route::get('/version', [HomeController::class, 'getVersion']);

    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::group(['prefix' => '/article-categories'], function () {
            Route::get('', [ArticleCategoryController::class, 'list']);
            Route::get('/{articleCategory}', [ArticleCategoryController::class, 'show']);
        });

        Route::group(['prefix' => '/articles'], function () {
            Route::post('', [ArticleController::class, 'create']);
            Route::get('', [ArticleController::class, 'list']);
            Route::get('/{article}', [ArticleController::class, 'show']);
            Route::put('/{article}', [ArticleController::class, 'update']);
            Route::delete('/{article}', [ArticleController::class, 'delete']);
        });

        // Is this supposed to be under auth?
        Route::group(['prefix' => '/subscribers'], function () {
            Route::get('', [SubscriberController::class, 'list']);
            Route::get('/{subscriber}', [SubscriberController::class, 'show']);
        });
    });
});
