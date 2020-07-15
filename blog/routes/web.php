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
Auth::routes();

ROute::match(['get','post'],'/admin','AdminController@login');

Route::group(['middleware' => ['auth']], function(){

    Route::get('/admin/dashboard','AdminController@dashboard');

    Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
    Route::get('/admin/view-categories','CategoryController@viewCategory');
    Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
    Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');

    //Route for products
    Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');

});


Route::get('/logout','AdminController@logout');