<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/submission', [DashboardController::class, 'submission'])->name('dashboard.submission');
    Route::get('/profile', [ProfileController::class, 'form'])->name('dashboard.profile.form');
    Route::post('/profile', [ProfileController::class, 'store'])->name('dashboard.profile.store');
    Route::put('/profile/{village}', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::post('/profile/{membership}/upload', [ProfileController::class, 'upload'])->name('dashboard.profile.upload');
    Route::get('/submission/{period}/form/', [SubmissionController::class, 'form'])->name('dashboard.user.submission.form');
    Route::post('/submission/{period}/form/', [SubmissionController::class, 'store'])->name('dashboard.user.submission.store');
    Route::get('/profile/index/preview', [ProfileController::class, 'preview'])->name('dashboard.profile.preview');
});

require __DIR__ . '/auth.php';


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
