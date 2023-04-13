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
    Route::any('/get_all_post', 'ApiPageController@getAllPost')->name('api.page.get_all');
    Route::any('/get_all_sync_page', 'ApiSyncPageController@getAll')->name('api.sync_page.get_all');

    Route::any('/compare/get', 'ApiCompareController@get')->name('api.compare.get');
    Route::any('/compare/detail', 'ApiCompareController@detail')->name('api.compare.detail');

    Route::any('/fetch/f99', 'ApiCrawlController@FetchApiF99')->name('api.fetch.f99');
    Route::any('/get_all_users', 'ApiAccountController@getAll')->name('api.account.get_all');

    Route::group(['prefix' => 'config'], function () {
        Route::get('/get_all', 'ApiConfigController@getAll')->name('api.config.get_all');
    });

    Route::group(['prefix' => 'cronjob'], function () {
        Route::any('/crawl_site', 'ApiCrawlController@crawlSite')->name('api.crawl.crawl_site');
        Route::any('/sync_content', 'ApiCrawlController@syncContent')->name('api.crawl.sync_content');
        Route::any('/remove_content', 'ApiCrawlController@removeContent')->name('api.crawl.remove_content');
        Route::any('/check_connection', 'ApiConfigController@checkConnection')->name('api.config.check_connection');
    });

});