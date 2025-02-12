<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RubricController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function () {
    Route::group([
                     'prefix' => 'auth'

                 ], function ($router) {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);

        Route::apiResource('companies', CompanyController::class)
             ->only(['index', 'show'])->middleware('auth:api');
        Route::get('companies/building/{id}', 'App\Http\Controllers\CompanyController@getByBuilding')->middleware('auth:api');
        Route::get('companies/rubric/{id}', 'App\Http\Controllers\CompanyController@getByRubric')->middleware('auth:api');
        Route::get('companies/map/point/{latitude}/{longitude}/{radius}', 'App\Http\Controllers\CompanyController@getByMapPoint')->middleware('auth:api');
        Route::get('companies/rectangle/{latitude1}/{longitude1}/{latitude2}/{longitude2}', 'App\Http\Controllers\CompanyController@getByRectangle')->middleware('auth:api');
        Route::get('buildings/map/point/{latitude}/{longitude}/{radius}', 'App\Http\Controllers\BuildingController@getByMapPoint')->middleware('auth:api');
        Route::get('buildings/rectangle/{latitude1}/{longitude1}/{latitude2}/{longitude2}', 'App\Http\Controllers\BuildingController@getByRectangle')->middleware('auth:api');
        Route::apiResource('buildings', BuildingController::class)
             ->only(['index', 'show'])->middleware('auth:api');
        Route::apiResource('rubrics', RubricController::class)
             ->only(['index', 'show'])->middleware('auth:api');

    });

});
