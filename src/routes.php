<?php

Route::group(['namespace' => 'Lbmadesia\ApiGenerator\Controllers', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'admin'] ], function () {
	Route::resource('apis', 'ApiController');

    //For DataTables
    Route::post('apis/get', 'ApiTableController')
        ->name('apis.get');
    //Checking namespace exists (file exists)
    Route::post('apis/checkNamespace', 'ApiController@checkNamespace')->name('apis.check.namespace');
    //checking table exists
    Route::post('apis/checkTable', 'ApiController@checkTable')->name('apis.check.table');
    //checking permission exists
    Route::post('apis/checkPermission', 'ApiController@checkPermission')->name('apis.check.permission');
});
