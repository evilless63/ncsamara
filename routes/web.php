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

Route::get('/admin', 'HomeController@index')->name('admin')->middleware(['verified','is_admin']);

Route::get('/user', 'HomeController@user')->name('user')->middleware('verified');

Route::prefix('user')->name('user.')->middleware('verified')->group(function () {
    Route::resource('profiles', 'ProfileController');
    Route::resource('salons', 'SalonController');

    Route::get('payments', 'ProfileController@payments')->name('payments');
    Route::post('makepayment', 'ProfileController@makepayment')->name('makepayment');
    Route::post('promotionalpayment', 'ProfileController@promotionalpayment')->name('promotionalpayment');
});

Route::prefix('admin')->middleware(['verified','is_admin'])->name('admin.')->group(function () {
    Route::get('profiles', 'ProfileController@adminindex')->name('adminprofiles');
    Route::resource('services', 'ServiceController');
    Route::resource('rates', 'RateController');
    Route::resource('promotionals', 'PromotionalController');
    Route::resource('bonuses', 'BonusController');
});


Route::post('/user/profiles/upload', 'ProfileController@fileUpload');
Route::post('/user/profiles/delete', 'ProfileController@removeUpload');
