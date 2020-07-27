<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'SiteController@index');
Route::get('/search/{search}', 'SiteController@index');
Route::get('/search/?q=search+with+%2f+slash', 'SiteController@index');

Route::get('/edit/{edit}', 'SiteController@edit');
Route::get('/discuss/{discuss}', 'SiteController@discuss');
Route::get('/history/{history}', 'SiteController@history');
Route::get('/about', 'SiteController@about');
Route::get('/contacts', 'SiteController@contacts');

Route::post('/update', 'SiteController@update');
Route::get('/create/{create}', 'SiteController@create');
Route::post('/store', 'SiteController@store');
Route::post('/upload', 'SiteController@upload');
Route::post('/ajaxFileUpload', 'SiteController@ajaxFileUpload');
