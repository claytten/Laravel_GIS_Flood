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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::namespace('Admin')->group(function () {
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('admin/login', 'LoginController@login')->name('admin.login');
    Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
});

Route::group(['prefix' => 'admin', 'middleware' => ['employee'], 'as' => 'admin.' ], function () {
    Route::namespace('Admin')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
    
        Route::namespace('Accounts')->group(function () {
            Route::resource('/account/admin', 'AdminController', ['except' => ['show'] ] );
            Route::resource('/account/role', 'RoleController');
        });
    });
});

/**
 * Customer routes
 */
Auth::routes();

Route::namespace('Front')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
});

