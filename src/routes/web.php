<?php

Route::group(['prefix' => 'api/igloo'], function() {
    Route::get('ping', 'Farhad\Igloo\Controllers\AutomateController@ping');
//    Route::get('index', 'Farhad\Igloo\Controllers\AutomateController@index');
//    Route::post('model', 'Farhad\Igloo\Controllers\AutomateController@model');
    Route::post('make', 'Farhad\Igloo\Controllers\AutomateController@make');
});

