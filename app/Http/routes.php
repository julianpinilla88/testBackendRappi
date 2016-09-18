<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::resource('/','FrontController@index');
Route::resource('login','LoginController');
Route::resource('user','UserController');
Route::resource('role','RoleXUserController');
Route::resource('password','PasswordController');
Route::get('auth/facebook', 'LoginController@redirectToProviderFacebook')->name('facebook.login');
Route::get('auth/facebook/callback', 'LoginController@handleProviderCallbackFacebook');

