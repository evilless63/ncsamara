<?php

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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user', 'HomeController@user')->name('user')->middleware('verified');

Route::prefix('user')->name('user.')->middleware('verified')->group(function () {
    Route::resource('profiles', 'ProfileController');
});

Route::prefix('admin')->middleware(['verified','is_admin'])->name('admin.')->group(function () {
    Route::resource('services', 'ServiceController');
});


Route::post('/user/profiles/upload', 'ProfileController@fileUpload');
Route::post('/user/profiles/delete', 'ProfileController@removeUpload');
