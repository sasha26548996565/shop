<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Api')->middleware('auth:api')->group(function () {
    Route::get('/sku', 'SkuController@getSku');
});
