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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/token', 'TokenController@getRemainingToken');

Route::get('getspid/{sponser_id}', 'ApiController@getspid');

Route::get('UserName', 'ApiController@UserName');

Route::get('pwdscriptapi', 'ApiController@ClientPasswordScriptapi');

Route::get('check_client_name/{username}', 'ApiController@check_client_name');
Route::get('createAffiliateBonus','ApiController@createAffiliateBonus');
Route::get('AllAffiliateIncome','ApiController@AllAffiliateIncome');