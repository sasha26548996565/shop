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
    Route::get('/reset', ResetController::class)->name('reset');

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
        Route::post('/add/{id}', 'BasketController@add')->name('-add');
        Route::post('/remove/{id}', 'BasketController@remove')->name('-remove');

        Route::middleware(['basket_not_empty'])->group(function () {
            Route::get('/', 'BasketController@index')->name('');
            Route::get('/place', 'BasketController@place')->name('-place');
            Route::post('/confirm', 'BasketController@confirm')->name('-confirm');
        });
    });

    Route::get('/categories', 'MainController@categories')->name('categories');
    Route::get('/{category}', 'MainController@category')->name('category');
    Route::get('/{category}/{productS}', 'MainController@product')->name('product');
});
