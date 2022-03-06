<?php

Route::group(['namespace' => 'Lbmadesia\ApiGenerator\Controllers', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'admin'] ], function () {
	Route::resource('apis', 'ApiController');

    //For DataTables
    Route::post('apis/get', 'ApiTableController')->name('apis.get');

    //checking table exists
    Route::post('apis/apiRoute', 'ApiController@apiRoute')->name('apis.check.route');

});
