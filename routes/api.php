<?php

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

Route::group(['prefix' => 'v1', 'middleware' => ['api', 'api.rate.limit']], function () {
    Route::get('coin/{symbol}', 'Api\CoinController@getCoin');
});

Route::get('/health', function () {
    return response()->json(['status' => 'healthy']); 
});
