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

//Пока что отключим проверку верификации, так как у нас не настроен драйвер и для теста это не так актуально

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Auth::routes(['verify' => true]);

Route::get('/admin', 'HomeController@index')->name('admin')->middleware(['verified','is_admin']);

Route::get('/user', 'HomeController@user')->name('user')->middleware(['verified','is_banned']);

//Route::prefix('user')->name('user.')->middleware('verified')->group(function () {
Route::prefix('user')->middleware('is_banned')->name('user.')->group(function () {
    Route::resource('profiles', 'ProfileController');
    Route::resource('salons', 'SalonController');

    Route::get('payments', 'ProfileController@payments')->name('payments');
    Route::post('makepayment', 'ProfileController@makepayment')->name('makepayment');
    Route::post('promotionalpayment', 'ProfileController@promotionalpayment')->name('promotionalpayment');

    Route::post('activateprofile/{id}', 'ProfileController@activate')->name('activateprofile');

    Route::patch('publish/{id}', 'ProfileController@publish')->name('profilepublish');
    Route::patch('unpublish/{id}', 'ProfileController@unpublish')->name('profileunpublish');
});

//Route::prefix('admin')->middleware(['verified','is_admin'])->name('admin.')->group(function () {
Route::prefix('admin')->middleware('is_admin')->name('admin.')->group(function () {
    Route::get('profiles', 'ProfileController@adminindex')->name('adminprofiles');
    Route::resource('services', 'ServiceController');
    Route::resource('rates', 'RateController');
    Route::resource('promotionals', 'PromotionalController');
    Route::resource('bonuses', 'BonusController');
    Route::patch('verify/{id}', 'ProfileController@verify')->name('profileverify');
    Route::patch('unverify/{id}', 'ProfileController@unverify')->name('profileunverify');
    Route::patch('userbanoff/{id}', 'ProfileController@userbanoff')->name('userbanoff');
    Route::patch('userbanon/{id}', 'ProfileController@userbanon')->name('userbanon');
});


Route::post('/user/profiles/upload', 'ProfileController@fileUpload');
Route::post('/user/profiles/delete', 'ProfileController@removeUpload');
