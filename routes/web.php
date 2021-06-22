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
Route::get('/product_list/{sub_cat_id}')->uses('Website\HomeController@getSubCategoryWiseProductList')->name('product_list');
Route::get('/about_us')->uses('Website\HomeController@aboutUs')->name('about_us');
Route::get('/contact_us')->uses('Website\HomeController@contactUs')->name('contact_us');
Route::post('/contact_message')->uses('Website\HomeController@contactMessage')->name('contact_message');

Route::resource('customer', 'Website\CustomerController');
Route::post('/customer_login')->uses('Website\CustomerController@customerLogin')->name('customer_login');
Route::get('/customer_logout')->uses('Website\CustomerController@customerLogout')->name('customer_logout');
Route::get('/customer_forgot_password')->uses('Website\CustomerController@customerForgotPassword')->name('customer_forgot_password');
Route::post('/send_customer_reset_password_link')->uses('Website\CustomerController@sendCustomerResetPasswordLink')->name('send_customer_reset_password_link');
Route::get('/customer_reset_password_link/{email?}/{token?}')->uses('Website\CustomerController@customerResetPasswordLink')->name('customer_reset_password_link');
Route::post('/change_customer_password')->uses('Website\CustomerController@changeCustomerPassword')->name('change_customer_password');

Route::resource('order', 'Website\OrderController');
Route::post('/add_to_cart')->uses('Website\OrderController@addToCart')->name('add_to_cart');
Route::get('/remove_from_cart/{cart_id}')->uses('Website\OrderController@removeFromCart')->name('remove_from_cart');
Route::get('/get_cart_list')->uses('Website\OrderController@getCartList')->name('get_cart_list');
Route::get('/get_single_product_image/{product_id}/{color_id}')->uses('Website\OrderController@getSingleProductImageByColor')->name('get_single_product_image');
Route::post('/place_order')->uses('Website\OrderController@placeOrder')->name('place_order');
Route::get('/my_orders')->uses('Website\OrderController@myOrders')->name('my_orders');
Route::get('/order_detail/{invoice_no}')->uses('Website\OrderController@orderDetail')->name('order_detail');

// ADMIN Start From Here...
Auth::routes(['login' => false, 'register' => false]);

Route::get('enzo_admin')->name('login')->uses('Auth\LoginController@showLoginForm');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('category', 'CategoryController');
Route::resource('sub_category', 'SubCategoryController');
Route::resource('product', 'ProductController');
Route::resource('company_info', 'CompanyInfoController');
Route::resource('admin_order', 'OrderController');

Route::post('/get_sub_category_list_by_cat_id', 'SubCategoryController@getSubCategoryListByCatId')->name('get_sub_category_list_by_cat_id');
Route::post('/get_existing_images', 'ProductController@getExistingImages')->name('get_existing_images');
Route::post('/delete_existing_image', 'ProductController@deleteExistingImage')->name('delete_existing_image');
Route::post('/delete_product_specification', 'ProductController@deleteProductSpecification')->name('delete_product_specification');
Route::get('/product_stock_management/{id}', 'ProductController@productStockManagement')->name('product_stock_management');
Route::post('/save_new_color_size_combination', 'ProductController@saveNewColorSizeCombination')->name('save_new_color_size_combination');
Route::post('/update_product_stock', 'ProductController@updateProductStock')->name('update_product_stock');
Route::get('/new_orders', 'OrderController@newOrders')->name('new_orders');
Route::get('/new_order_detail/{id}', 'OrderController@newOrderDetail')->name('new_order_detail');
Route::get('/order_confirm/{id}', 'OrderController@orderConfirm')->name('order_confirm');
Route::put('/shipment_confirm/{id}', 'OrderController@shipmentConfirm')->name('shipment_confirm');
Route::get('/order_deliver/{id}', 'OrderController@orderDeliver')->name('order_deliver');
Route::post('/filter_product', 'ProductController@filterProduct')->name('filter_product');


// Artisan Commands
Route::get('/cleareverything', function () {
    $clearcache = Artisan::call('cache:clear');
    echo "Cache cleared<br>";

    $clearview = Artisan::call('view:clear');
    echo "View cleared<br>";

    $clearconfig = Artisan::call('config:cache');
    echo "Config cleared<br>";
});

Route::get('/optimize', function () {
    $clearcache = Artisan::call('optimize:clear');
    echo "Cache cleared<br>";
});

Route::get('/storage_link', function () {
    $clearcache = Artisan::call('storage:link');
    echo "Storage Link<br>";
});