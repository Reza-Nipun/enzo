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

// Website Start From Here...
Route::get('/')->uses('Website\HomeController@index')->name('index');
Route::post('/get_products_by_id')->uses('Website\HomeController@getProductsById')->name('get_products_by_id');
Route::post('/get_product_images')->uses('Website\HomeController@getProductImages')->name('get_product_images');
Route::get('/view_single_product/{id}/{color_id?}')->uses('Website\HomeController@viewSingleProduct')->name('view_single_product');


// ADMIN Start From Here...
Auth::routes(['login' => false, 'register' => false]);

Route::get('enzo_admin')->name('login')->uses('Auth\LoginController@showLoginForm');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('category', 'CategoryController');
Route::resource('sub_category', 'SubCategoryController');
Route::resource('product', 'ProductController');

Route::post('/get_sub_category_list_by_cat_id', 'SubCategoryController@getSubCategoryListByCatId')->name('get_sub_category_list_by_cat_id');
Route::post('/get_existing_images', 'ProductController@getExistingImages')->name('get_existing_images');
Route::post('/delete_existing_image', 'ProductController@deleteExistingImage')->name('delete_existing_image');
Route::post('/delete_product_specification', 'ProductController@deleteProductSpecification')->name('delete_product_specification');
Route::get('/product_stock_management/{id}', 'ProductController@productStockManagement')->name('product_stock_management');
Route::post('/save_new_color_size_combination', 'ProductController@saveNewColorSizeCombination')->name('save_new_color_size_combination');
Route::post('/update_product_stock', 'ProductController@updateProductStock')->name('update_product_stock');
