<?php

Route::get('validate_emails', function() {
    return 'Validate Emails';
});
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