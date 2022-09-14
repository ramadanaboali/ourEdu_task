<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['api','lang'],'namespace' => 'Api'], function () {



        Route::group(['namespace' => 'Product', 'prefix' => 'products'], function () {
            // index
            Route::get('/', 'ProductController@index');
            // create
            Route::post('/', 'ProductController@store');
            // get
            Route::get('{Product}', 'ProductController@get');
            // update
            Route::put('{Product}', 'ProductController@update');
            // delete
            Route::delete('bulkDelete', 'ProductController@bulkDelete');
            Route::post('bulkRestore', 'ProductController@bulkRestore');
        });

});




