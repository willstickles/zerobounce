<?php

use Willstickles\Zerobounce\Http\Controllers\ZeroBounceController;

Route::group(['namespace' => 'Willstickles\Zerobounce\Http\Controllers', 'middleware' => ['cors']], function() {
    Route::get('validate_email', 'ZeroBounceController@index');
    Route::get('validate_emails', 'ZeroBounceController@validateEmail');

    Route::post('validate_emails', 'ZeroBounceController@validateEmail');

    Route::get('get_credit_balance', 'ZeroBounceController@getCreditBalance');
    Route::get('delete_file', function() {
        return 'Delete File';
    });
    Route::get('send_file', 'ZeroBounceController@sendFile');
});

