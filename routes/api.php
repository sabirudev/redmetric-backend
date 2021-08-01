<?php

use App\Http\Middleware\JuryMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')
    ->namespace('App\Http\Controllers\Api')
    ->prefix('user')
    ->group(function () {
        Route::apiResource('submissions', 'SubmissionApiController', ['names' => 'api.user.submission']);
        Route::apiResource('villages', 'VillageApiController', ['names' => 'api.user.villages']);
        Route::group(['prefix' => 'submissions'], function () {
            Route::get('my/index', 'UserSubmisionApiController@index')->name('api.user.submissions.my.index');
        });
    });
Route::middleware('auth:api')
    ->namespace('App\Http\Controllers\Api')
    ->prefix('admin')
    ->group(function () {
        Route::apiResource('users', 'UserApiController', ['names' => 'api.admin.users']);
        Route::apiResource('periods', 'PeriodApiController', ['names' => 'api.admin.periods']);
    });

Route::middleware(['auth:api', JuryMiddleware::class])
    ->namespace('App\Http\Controllers\Api')
    ->prefix('jury')
    ->group(function () {
        Route::apiResource('todos', 'JuryTodoApiController', ['names' => 'api.jury.todos']);
        Route::get('todos/index/mylist', 'JuryTodoApiController@mylist')->name('api.jury.todos.mylist');
    });
