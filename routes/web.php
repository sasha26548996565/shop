<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => true
]);

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/locale/{locale}', 'LocalizableController@switchLocale')->name('changeLocale');
    Route::get('/switchCurrency/{currencyCode}', 'CurrencyController@switchcurrency')->name('switchCurrency');

    Route::middleware(['locale'])->group(function () {
        Route::middleware('auth')->prefix('person')->name('person.')->namespace('Person')->group(function () {
            Route::get('/order', 'OrderController@index')->name('order');
            Route::get('/order/{order}', 'OrderController@show')->name('order.show');
        });

        Route::namespace('Admin')->middleware(['auth', 'admin', 'verified'])->prefix('admin')->name('admin.')->group(function () {

            Route::get('/order', 'OrderController@index')->name('order');
            Route::get('/order/{order}', 'OrderController@show')->name('order.show');

            Route::resource('categories', 'CategoryController');
            Route::resource('products', 'ProductController');
            Route::resource('products/{product}/skus', 'SkuController');
            Route::resource('properties', 'PropertyController');
            Route::resource('properties/{property}/property-options', 'PropertyOptionController');
            Route::resource('coupons', 'CouponController');
            Route::resource('merchants', 'MerchantController');
            Route::get('merchants/{merchant}/update-token', 'MerchantController@updateToken')->name('merchants.update_token');
        });

        Route::get('/', 'MainController@index')->name('index');

        Route::name('basket')->prefix('basket')->group(function () {
            Route::post('/add/{sku}', 'BasketController@add')->name('-add');
            Route::post('/coupon', 'CouponController@add')->name('-coupon-save');

            Route::middleware(['basket_not_empty'])->group(function () {
                Route::get('/', 'BasketController@index')->name('');
                Route::get('/place', 'BasketController@place')->name('-place');
                Route::post('/confirm', 'BasketController@confirm')->name('-confirm');
                Route::post('/remove/{sku}', 'BasketController@remove')->name('-remove');
            });
        });

        Route::get('/categories', 'MainController@categories')->name('categories');
        Route::get('/categories/{category}', 'MainController@category')->name('category');
        Route::get('/{category}/{product}/{sku}', 'MainController@sku')->name('sku');
        Route::post('subscription/{sku}', 'MainController@subscripe')->name('subscription');
    });

    //Route::middleware('reset')->get('/reset/fghfgh/fghfg/hfg/hf/gh/fgh/gf', 'ResetController')->name('reset');
});
