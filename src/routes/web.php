<?php

Route::group(['prefix' => 'igloo'], function() {

    Route::get('/', 'InfancyIt\Igloo\Controllers\AutomateController@igloo');

    Route::group(['prefix' => 'api'], function() {
        Route::get('ping', 'InfancyIt\Igloo\Controllers\AutomateController@ping');
        Route::post('make', 'InfancyIt\Igloo\Controllers\AutomateController@make');
    });
});

