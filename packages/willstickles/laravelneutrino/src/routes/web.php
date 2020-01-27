<?php

use Willstickles\LaravelNeutrino\Http\Controllers\NeutrinoController;

Route::group(['namespace' => 'Willstickles\LaravelNeutrino\Http\Controllers', 'middleware' => ['cors']], function() {
    Route::get('validate_emails', 'NeutrinoController@index')->name('validate_emails');
    Route::get('validate_email', 'NeutrinoController@validateEmail')->name('validate_email');

    Route::get('get_credit_balance', function() {
        return 'Get Credit Balance';
    });
    Route::get('file_status', function() {
        return 'File Status';
    });
    Route::get('delete_file', function() {
        return 'Delete File';
    });
    Route::post('send_file', function() {
        return response()->json(['message' => 'File Sent']);
    });
});

