<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/api'], function () {
    Route::get('/version', [HomeController::class, 'getVersion']);

    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::group(['prefix' => '/article-categories'], function () {
            Route::get('', [ArticleCategoryController::class, 'index']);
            Route::get('/{articleCategory}', [ArticleCategoryController::class, 'show']);
        });

        Route::group(['prefix' => '/articles'], function () {
            Route::post('', [ArticleController::class, 'create']);
            Route::get('', [ArticleController::class, 'index']);
            Route::get('/{article}', [ArticleController::class, 'show']);
            Route::put('/{article}', [ArticleController::class, 'update']);
            Route::delete('/{article}', [ArticleController::class, 'delete']);
        });
    });
});
