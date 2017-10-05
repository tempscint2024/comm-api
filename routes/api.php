<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::post('signUpUser', 'api\v1\AuthenticateController@RegisterUser');

    Route::post('signUpMerchant', 'api\v1\AuthenticateController@RegisterMerchant');

    Route::group(['prefix' => 'productCategories'], function () {

        Route::get('/', 'api\v1\ProductCategoryController@getAllProductCategories');

        Route::get('topLevelCategories', 'api\v1\ProductCategoryController@getTopLevelProductCategories');

    });























});
