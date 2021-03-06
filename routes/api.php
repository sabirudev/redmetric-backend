<?php

use App\Http\Controllers\Api\UserSubmisionApiController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\JuryMiddleware;

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
            Route::get('valid/period', 'PeriodApiController@valid')->name('api.user.submissions.valid.period');
            Route::post('upload/evidence/{submit}', 'SubmissionApiController@evidence', ['names' => 'api.user.submission.upload.evidence']);
        });
    });
Route::middleware(['auth:api', AdminMiddleware::class])
    ->namespace('App\Http\Controllers\Api')
    ->prefix('admin')
    ->group(function () {
        Route::apiResource('users', 'UserApiController', ['names' => 'api.admin.users']);
        Route::apiResource('periods', 'PeriodApiController', ['names' => 'api.admin.periods']);
        Route::get('index/all/submissions', 'UserSubmisionApiController@all', ['names' => 'api.admin.index.submissions']);
    });

Route::middleware(['auth:api', JuryMiddleware::class])
    ->namespace('App\Http\Controllers\Api')
    ->prefix('jury')
    ->group(function () {
        Route::apiResource('todos', 'JuryTodoApiController', ['names' => 'api.jury.todos']);
        Route::get('todos/index/mylist', 'JuryTodoApiController@mylist')->name('api.jury.todos.mylist');
    });
// public file
Route::get('preview/{uploaded}', [UserSubmisionApiController::class, 'show'])->name('api.user.preview.uploaded');
