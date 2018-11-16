<?php

Route::group(['prefix' => 'api/igloo'], function() {
    Route::get('ping', 'InfancyIt\Igloo\Controllers\AutomateController@ping');
    Route::post('make', 'InfancyIt\Igloo\Controllers\AutomateController@make');
});

