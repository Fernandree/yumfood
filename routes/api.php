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

Route::prefix('v1')->group(function () {
    Route::apiResource('vendors', 'VendorController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('vendor/','VendorController@index'); // Show All
Route::get('vendor/{id}','VendorController@show'); // Show specified id only
Route::post('vendor','VendorController@store'); // Create
Route::delete('vendor/{id}','VendorController@destroy'); // Delete
Route::put('vendor/{id}','VendorController@update'); // Update


Route::get('vendor/','VendorController@index'); // Show All
Route::get('vendorSearch','VendorController@searchTag'); // Search Tags
Route::get('vendorMenu','VendorController@searchMenu'); // Search Menu
Route::post('vendorOrder','VendorController@makeOrder'); // Make Order
Route::get('vendorOrder/show','VendorController@showOrder'); // Show Orders