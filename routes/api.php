<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'Api'],function(){
    Route::any('/start-crawl', 'ApiCrawlController@start')->name('api.crawl.start');

    Route::any('/compare/get', 'ApiCompareController@get')->name('api.compare.get');
    Route::any('/compare/detail', 'ApiCompareController@detail')->name('api.compare.detail');

    Route::any('/fetch/f99', 'ApiCrawlController@FetchApiF99')->name('api.fetch.f99');
});