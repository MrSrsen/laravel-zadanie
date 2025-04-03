<?php

use App\Http\Controllers\ArticleCategoryAbstractController;
use App\Http\Controllers\ArticleAbstractController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriberAbstractController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/api'], function () {
    Route::get('/version', [HomeController::class, 'getVersion']);

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

/*Route::controller(AuthController::class)
    ->group(function () {
        // TODO: add auth endpoints
    });

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function (Router $router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');
});

Route::controller(SubscriberController::class)
    ->group(function () {
        // TODO: add subscriber endpoints
    });

Route::controller(ArticleController::class)
    ->group(function () {
        // TODO: add article endpoints
    });

Route::controller(ArticleCategoryController::class)
    ->group(function () {
        // TODO: add article category endpoints
    });*/
