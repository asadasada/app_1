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

///////////////////////登録周り//////////////////////////////////////

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
///////////////////////////////////////////////////////////////////////
// home
Route::get('/', 'HomeController@index')->name('home');
Route::get('{user}/profile{tag_name?}', 'hogeta618\hoge618con@profile')->name("profile");
Route::post('{user}/profile/update', 'hogeta618\hoge618con@updateDir')->name("updateDir");
Route::post('{user}/profile/upload', 'hogeta618\hoge618con@edit')->name("user_edit");
//データなし例外の代替route
Route::get('{user}/profile/edit',function (){return view("home");});

///追加
Route::get('{user}/c_profile', 'hogeta618\hoge618con@fromu_C_profile')->name("c_profile");

//////////////////////////////////customers////////////////////////////
Route::group(['prefix' => 'customers'], function(){

//home
    Route::get('home', 'Customers\HomeController@index')->name('customers.home');
//login logout
    Route::get('login', 'Customers\Auth\LoginController@showLoginForm')->name('customers.login');
    Route::post('login', 'Customers\Auth\LoginController@login')->name('customers.login');
    Route::post('logout', 'Customers\Auth\LoginController@logout')->name('customers.logout');
//register
    Route::get('register', 'Customers\Auth\RegisterController@showRegisterForm')->name('customers.register');
    Route::post('register', 'Customers\Auth\RegisterController@register')->name('customers.register');
    //profile
    Route::get('{customer}/profile{tag_name?}', 'Customers\C_hoge618con@profile')->name("customers.profile");
    //user側への処理
    Route::get('{customer}/u_profile{tag_name?}', 'Customers\C_hoge618con@fromC_u_profile')->name("customers.u_profile");
    Route::post('{customer}/profile/update', 'Customers\C_hoge618con@updateDir')->name("customers.updateDir");
    Route::post('{customer}/profile/upload', 'Customers\C_hoge618con@edit')->name("customers.edit");
//データなし例外の代替route
    Route::get('{customer}/profile/edit',function (){return view("customers.home");});

});