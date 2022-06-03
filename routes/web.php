<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/', 'MainController@index')->name('index');

    Route::get('/basket', 'BasketController@basket')->name('basket');
    Route::get('/basket/place', 'BasketController@basketPlace')->name('basket-place');
    Route::post('/basket/add/{id}', 'BasketController@add')->name('basket-add');

    Route::get('/categories', 'MainController@categories')->name('categories');
    Route::get('/{category}', 'MainController@category')->name('category');
    Route::get('/{category}/{productS}', 'MainController@product')->name('product');
});
