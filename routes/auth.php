<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', [
	App\Http\Controllers\DashboardController::class, 'index',
])->name('dashboard');

Route::resource('roles', App\Http\Controllers\RoleController::class);

Route::get('profile', [App\Http\Controllers\UserController::class, 'showProfile'])->name('users.profile');
Route::patch('profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('users.updateProfile');
Route::post('changePassword', [App\Http\Controllers\UserController::class, 'changePassword'])->name('users.changePassword');

Route::resource('users', App\Http\Controllers\UserController::class);
Route::post('users/send-reset-password-link', 'App\Http\Controllers\UserController@sendResetPasswordLink')->name('users.send-reset-password-link');

Route::controller(CategoryController::class)->group(function(){
	Route::get('categories/getData', [CategoryController::class, 'getData'])->name('categories.getData');
	Route::resource('categories', CategoryController::class);
});


