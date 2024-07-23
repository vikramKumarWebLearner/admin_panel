<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
Auth::routes();

Route::get('/', function () {
	return redirect(route('dashboard'));
})->name('home');

Route::get('/set-password/{token}', [App\Http\Controllers\Auth\SetPasswordController::class, 'showSetPasswordForm'])->name('password.set')->middleware('guest');
Route::post('/set-password', [App\Http\Controllers\Auth\SetPasswordController::class, 'setPassword'])->name('password.set')->middleware('guest');
Route::get('/thank-you', function () {
	return view('auth.emails.thankyou');
})->name('thankyou');

Route::post('profile/image/upload', [App\Http\Controllers\UserController::class, 'upload'])->name('users.profile.image');

// Route::get('users', ['uses' => 'UserController@index', 'as' => 'users.index']);

Route::post('/userss/{id}', [UserController::class, 'destroyUser'])->name('userss.destroy');

Route::post('/set-password-resend', [App\Http\Controllers\UserController::class, 'sendSetPasswordEmail'])->name('users.set-password');

// routes/web.php
Route::get('/users/data', [UserController::class, 'getUserData'])->name('users.data');

