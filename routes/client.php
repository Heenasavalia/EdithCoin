<?php
Route::get('home','TokenController@index')->name('home');

Route::resource('token','TokenController');
Route::get('process_mining_side','TokenController@processminingtoken');
Route::any('getalltokendata','TokenController@getalltokendata')->name('getalltokendata');


Route::any('fetch_data','TokenController@fetch_data')->name('fetch_data');

Route::get('getamttoken/{type}/{value}','TokenController@getamttoken');

Route::get('process_mining','TokenController@ProcessMiningPage');


Route::get('get_token_record','TokenController@get_token_record');
