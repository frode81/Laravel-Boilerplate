<?php

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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('signup', 'Auth\RegisterController@register');

// E-Mail Verification Routes...
// Route::get('verification/resend', 'Auth\VerificationController@resend')->name('verification.resend');
// Route::get('verification', 'Auth\VerificationController@show')->name('verification.notice');
// Route::get('verification/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');

// Password Confirmation Routes...
Route::get('password-confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password-confirm', 'Auth\ConfirmPasswordController@confirm');

// Password Reset Routes...
Route::post('password-reset/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password-reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password-reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::get('password-reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

// Page Routes...
Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::middleware('password.confirm')->group(function () {
        Route::get('profile', 'ProfileController@edit')->name('profile.edit');
        Route::put('profile', 'ProfileController@update')->name('profile.update');
    });
});

// Administrator Routes...
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware(['auth', 'permission:view backend'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('users', 'UserController');
    Route::patch('users/{id}/restore', 'UserController@restore')->name('users.restore');
});
