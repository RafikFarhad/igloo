<?php












Route::group(['prefix' => 'igloo'], function() {
    Route::get('ping', 'InfancyIT\Igloo\Controllers\AutomateController@ping');
    Route::get('index', 'InfancyIT\Igloo\Controllers\AutomateController@index');
    Route::post('model', 'InfancyIT\Igloo\Controllers\AutomateController@model');
    Route::post('make', 'InfancyIT\Igloo\Controllers\AutomateController@make');
});

