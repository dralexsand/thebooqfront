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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'SiteController@index');
Route::get('/search/{search}', 'SiteController@index');

Route::get('/edit/{edit}', 'SiteController@edit');
Route::get('/discuss/{discuss}', 'SiteController@discuss');
Route::get('/history/{history}', 'SiteController@history');
Route::get('/about', 'SiteController@about');
Route::get('/contacts', 'SiteController@contacts');

Route::post('/update', 'SiteController@update');
Route::post('/create', 'SiteController@create');
Route::post('/upload', 'SiteController@upload');
Route::post('/ajaxFileUpload', 'SiteController@ajaxFileUpload');
