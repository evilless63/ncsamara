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

Route::get('/', 'SiteController@index')->name('index');
Route::get('/profiles/{id}', 'SiteController@profile')->name('getprofile');
Route::get('/on-map', 'SiteController@map')->name('onmap');
Route::get('/salons', 'SiteController@salons')->name('salons');
Route::get('/add-profile', 'SiteController@addprofile')->name('addprofile');
Route::get('/arhived', 'SiteController@archived')->name('archived');
Route::post('/loadmore/load_data', 'SiteController@load_data')->name('loadmore.load_data');

//Пока что отключим проверку верификации, так как у нас не настроен драйвер и для теста это не так актуально
Auth::routes();
//Auth::routes(['verify' => true]);

Route::get('/admin', 'HomeController@index')->name('admin')->middleware(['verified', 'is_admin']);

Route::get('/user', 'HomeController@user')->name('user')->middleware(['verified', 'is_banned']);

//Route::prefix('user')->name('user.')->middleware('verified')->group(function () {
Route::prefix('user')->middleware(['is_banned'])->name('user.')->group(function () {


    Route::resource('profiles', 'ProfileController');
    Route::resource('salons', 'SalonController');

    Route::patch('profilepublish/{id}', 'ProfileController@publish')->name('profilepublish');
    Route::patch('profileunpublish/{id}', 'ProfileController@unpublish')->name('profileunpublish');
    Route::post('profilechangephone', 'ProfileController@changephone')->name('profilechangephone');
    Route::post('profilechangerate', 'ProfileController@changerate')->name('profilechangerate');
    Route::patch('salonpublish/{id}', 'SalonController@publish')->name('salonpublish');
    Route::patch('salonunpublish/{id}', 'SalonController@unpublish')->name('salonunpublish');
    Route::post('/changeserviceprice', 'ProfileController@changeServicePrice')->name('service.pricechange');

    Route::post('/detachservice', 'ProfileController@detachService')->name('service.detach');
    Route::post('/attachservice', 'ProfileController@attachService')->name('service.attach');

    Route::get('payments', 'ProfileController@payments')->name('payments');
    Route::post('makepayment', 'ProfileController@makepayment')->name('makepayment');
    Route::get('successpayment', 'ProfileController@successpayment')->name('successpayment');
    Route::get('errorpayment', 'ProfileController@errorpayment')->name('errorpayment');
    Route::post('plusbonusinfo', 'ProfileController@plusbonusinfo')->name('plusbonusinfo');
    Route::post('promotionalpayment', 'ProfileController@promotionalpayment')->name('promotionalpayment');
    Route::post('/deleteimagesattach', 'ProfileController@deleteimagesattach')->name('images.deleteimageattach');
});

Route::prefix('admin')->middleware('is_admin')->name('admin.')->group(function () {
    Route::get('profiles', 'ProfileController@adminindex')->name('adminprofiles');
    Route::resource('services', 'ServiceController');
    Route::resource('rates', 'RateController');
    Route::resource('salonrates', 'SalonrateController');
    Route::resource('promotionals', 'PromotionalController');
    Route::resource('bonuses', 'BonusController');

    Route::patch('verify/{id}', 'ProfileController@verify')->name('profileverify');
    Route::patch('unverify/{id}', 'ProfileController@unverify')->name('profileunverify');

    Route::patch('moderateallow/{id}', 'ProfileController@moderateallow')->name('profilemoderateallow');
    Route::patch('moderatedisallow/{id}', 'ProfileController@moderatedisallow')->name('profilemoderatedisallow');

    Route::patch('salonmoderateallow/{id}', 'SalonController@moderateallow')->name('salonmoderateallow');
    Route::patch('salonmoderatedisallow/{id}', 'SalonController@moderatedisallow')->name('salonmoderatedisallow');

    Route::patch('userbanoff/{id}', 'ProfileController@userbanoff')->name('userbanoff');
    Route::patch('userbanon/{id}', 'ProfileController@userbanon')->name('userbanon');
});

Route::post('/user/profiles/upload', 'ProfileController@fileUpload');
Route::post('/user/profiles/delete', 'ProfileController@removeUpload');

Route::post('user/salons/uploadsalonimage', 'SalonController@fileUpload');
