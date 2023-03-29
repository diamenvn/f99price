<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace'=>'Site','prefix' => ''],function(){
    Route::get('/', 'SiteHomeController@index')->name('site.home');
    Route::get('/dashboard', 'SiteHomeController@dashboard')->name('site.home.dashboard');
    Route::get('/add_page', 'SiteHomeController@AddPage')->name('site.sidebar.add_page');
    Route::post('/add_page', 'SiteHomeController@storeAddPage')->name('site.sidebar.storeAddPage');
    Route::resource('/compare', 'SiteCompareController');
    Route::resource('/setting', 'SiteSettingController');

    Route::resource('/crawl_pages', 'SitePageController');
});