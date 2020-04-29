<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([
    'middleware' => 'api', 'corse',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('me', 'Auth\AuthController@me');
    Route::get('pdf', 'Auth\AuthController@pdf');
    Route::get('download-proof', 'Auth\AuthController@downloadProof');
    Route::get('settings', 'Admin\AuthController@getSettings');
    Route::get('company', 'Auth\AuthController@getCompany');
    Route::get('packages', 'Admin\PackageController@getPackages');
    Route::post('save-card-with-photo', 'CardController@saveCardWithPhoto');
    Route::post('save-card', 'CardController@saveCard');
    Route::get('get-card', 'CardController@getCard');
    // orders
    Route::get('get-orders', 'CardController@getOrders');

    Route::get('get-sr-past-orders', 'CardController@getSRPastOrders');
    Route::get('get-sh-past-orders', 'CardController@getSHPastOrders');

    Route::get('approve-order', 'CardController@approveOrder');
    Route::post('delete-order', 'CardController@deleteOrder');
    Route::get('fonts', 'CardController@fonts');
});

Route::group([

    'middleware' => 'api','cors',
    'prefix' => 'admin'

], function ($router) {

    Route::post('login', 'Admin\AuthController@login');
    Route::post('logout', 'Admin\AuthController@logout');
    Route::post('refresh', 'Admin\AuthController@refresh');
    Route::post('me', 'Admin\AuthController@me');
    Route::get('pdf', 'Admin\AuthController@pdf');
    Route::get('settings', 'Admin\AuthController@getSettings');
    Route::post('update-settings', 'Admin\AuthController@updateSettings');
    Route::get('users', 'Admin\AuthController@users');
    Route::post('update-user', 'Admin\AuthController@updateUser');
    Route::post('delete-user', 'Admin\AuthController@deleteUser');
    Route::post('adduser', 'Admin\AuthController@addUser');
    

    Route::get('get-orders', 'CardController@getOrders');
    Route::get('get-past-orders', 'CardController@getPastOrders');
    Route::post('delete-order', 'CardController@deleteOrder');
    Route::get('packages', 'Admin\PackageController@getPackages');
    Route::post('update-package', 'Admin\PackageController@updatePackage');
    Route::post('delete-package', 'Admin\PackageController@deletePackage');
    Route::post('add-package', 'Admin\PackageController@addPackage');  

    // Company routes
    Route::get('companies', 'Admin\CompanyController@index');
    Route::post('update-company', 'Admin\CompanyController@update');
    Route::get('branches', 'Admin\CompanyController@getBranches');
    Route::post('update-branch', 'Admin\CompanyController@updateBranch');
});
