<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

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

Route::get('/login', function () {
    return view('pages.login');
})->middleware('not.auth')->name('login');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout')->middleware("auth");
Route::get('/', [HomeController::class, 'index'])->name('index')->middleware("auth");
Route::get('/auth-settings', [UserController::class, 'authSetings'])->name('auth.settings')->middleware("auth");

// APIS
Route::group(['prefix' => 'api'], function () {
    Route::post('/user/attempt', [UserController::class, 'attempt']);
    Route::post('/user/save-face-recognition', [UserController::class, 'saveFaceRecognition']);
});
