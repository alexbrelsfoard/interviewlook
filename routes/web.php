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

Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Look Routes
Route::get('/demos', 'LookController@demos')->name('look.demos');
Route::get('/about', 'LookController@about')->name('look.about');
Route::get('/verify/email/{token}', 'LookController@verifyEmail')->name('look.verify.email');

// User Routes
Route::get('user/{username}', 'UserController@profile')->name('user.profile');
Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {
    Route::get('edit', 'UserController@edit')->name('profile.edit');
    Route::post('update', 'UserController@update')->name('profile.update');
});

// Social Login Routes
Route::prefix('social')->group(function () {
    Route::get('linkedin', 'SocialController@linkedin')->name('social.linkedin');
    Route::get('linkedin/callback', 'SocialController@linkedinCallback')->name('social.linkedin.callback');
    Route::get('facebook', 'SocialController@facebook')->name('social.facebook');
    Route::get('facebook/callback', 'SocialController@facebookCallback')->name('social.facebook.callback');
});
