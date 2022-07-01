<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false
]);

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/locale/{locale}', 'LocalizableController@switchLocale')->name('changeLocale');
    Route::get('/switchCurrency/{currencyCode}', 'CurrencyController@switchcurrency')->name('switchCurrency');

    Route::middleware(['locale'])->group(function () {
        Route::middleware('auth')->prefix('person')->name('person.')->namespace('Person')->group(function () {
            Route::get('/order', 'OrderController@index')->name('order');
            Route::get('/order/{order}', 'OrderController@show')->name('order.show');
        });

        Route::namespace('Admin')->middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

            Route::get('/order', 'OrderController@index')->name('order');
            Route::get('/order/{order}', 'OrderController@show')->name('order.show');

            Route::resource('categories', 'CategoryController');
            Route::resource('products', 'ProductController');
        });

        Route::get('/', 'MainController@index')->name('index');

        Route::name('basket')->prefix('basket')->group(function () {
            Route::post('/add/{product}', 'BasketController@add')->name('-add');

            Route::middleware(['basket_not_empty'])->group(function () {
                Route::get('/', 'BasketController@index')->name('');
                Route::get('/place', 'BasketController@place')->name('-place');
                Route::post('/confirm', 'BasketController@confirm')->name('-confirm');
                Route::post('/remove/{product}', 'BasketController@remove')->name('-remove');
            });
        });

        Route::get('/categories', 'MainController@categories')->name('categories');
        Route::get('/categories/{category}', 'MainController@category')->name('category');
        Route::get('/{category}/{productS}', 'MainController@product')->name('product');
        Route::post('subscription/{product}', 'MainController@subscripe')->name('subscription');
    });

    //Route::middleware('reset')->get('/reset/fghfgh/fghfg/hfg/hf/gh/fgh/gf', 'ResetController')->name('reset');
});
