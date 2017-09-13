<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 		'MainController@showWelcome');
Route::get('/register', 'MainController@showRegister');
Route::get('/contact',	'MainController@showContact');
Route::get('/demos',	'MainController@showDemos');
Route::get('/login',	'MainController@showLogin');


// Route::get('/profile', 'LookieController@showProfile');