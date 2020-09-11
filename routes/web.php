<?php
use Illuminate\Support\Facades\URL;
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

Route::get('/','MainController@getIndex')->name('getIndex');

Route::get('/companylist','MainController@getCompany')->name('getCompany');

Route::get('/addprofile','MainController@getAddProfile')->name('getAddProfile');

Route::post('/postaddprofile','MainController@postAddProfile')->name('postAddProfile');

Route::get('/editprofile{id}','MainController@editProfile')->name('editProfile');

Route::post('/posteditprofile','MainController@postEditProfile')->name('postEditProfile');

Route::get('/product','MainController@getProduct')->name('getProduct');

Route::post('/ajaxdeleteproduct','MainController@ajaxDeleteProduct')->name('ajaxDeleteProduct');

Route::post('/ajaxaddproduct','MainController@ajaxAddProduct')->name('ajaxAddProduct');

Route::get('/variation','MainController@getVariation')->name('getVariation');

Route::post('/addvariation','MainController@ajaxAddVariation')->name('ajaxAddVariation');

Route::post('/ajaxdeletevariation','MainController@ajaxDeleteVariation')->name('ajaxDeleteVariation');


