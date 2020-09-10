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


