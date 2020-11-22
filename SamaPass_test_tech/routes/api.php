<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Salary routes
Route::get('salaries', 'Api\SalaryControllerAPI@index');
Route::get('salaries/{id}', 'Api\SalaryControllerAPI@show');
Route::post('salaries', 'Api\SalaryControllerAPI@store');
Route::put('salaries/{id}', 'Api\SalaryControllerAPI@update');
Route::delete('salaries/{id}','Api\SalaryControllerAPI@destroy');
Route::post('salaries/import', 'Api\SalaryControllerAPI@import');
