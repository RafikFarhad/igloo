<?php

Route::group(['prefix' => 'api'], function() {

    Route::get('igloo', 'InfancyIt\Igloo\Controllers\AutomateController@igloo');

    Route::group(['prefix' => 'igloo'], function() {
        Route::get('ping', 'InfancyIt\Igloo\Controllers\AutomateController@ping');
        Route::post('make', 'InfancyIt\Igloo\Controllers\AutomateController@make');
    });
});

