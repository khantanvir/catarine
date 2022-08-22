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
    return view('home/index');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('user-login', 'HomeController@login');
Route::get('user-register', 'HomeController@register');
Route::post('user-ragistration-process', 'HomeController@user_ragistration_process');
Route::get('dashboard', 'DashboardController@index');
Route::get('signout', 'HomeController@signout');
Route::get('create-user', 'DashboardController@create_user');
Route::post('post-user-data', 'DashboardController@post_user_data');
Route::post('custom/login', 'HomeController@custom_login');

Route::get('all-users', 'DashboardController@all_users');
Route::get('terms-condition', 'HomeController@terms_condition');
//user pfofile and billing info update
Route::post('update-profle-info', 'HomeController@update_profle_info');
Route::get('profile', 'HomeController@profile');
Route::get('contact-us', 'HomeController@contact_us');
Route::post('contact-us-post-data', 'HomeController@contact_us_post_data');
//password change code
Route::post('change-password-store', 'HomeController@change_password_store');
//catarine
Route::get('create-catarine-user', 'CatarineController@create');
Route::post('post-user-data', 'CatarineController@post_catarine_user_data');
Route::get('all-catarine-users', 'CatarineController@all_catarine_users');
Route::get('catarine-details/{id}', 'CatarineController@catarine_details');
Route::get('catarine-product-details/{id}', 'CatarineController@catarine_product_details');
Route::get('search-catarine', 'CatarineController@search_catarine');
Route::get('search-catarine/{id}/{id1}', 'CatarineController@search_catarine');
//code for catarine user dashboard
Route::get('create-main-image', 'CatarineController@create_main_image');
Route::post('create-main-image-post', 'CatarineController@create_main_image_post');
Route::get('create-cover-image', 'CatarineController@create_cover_image');
Route::post('create-cover-image-post', 'CatarineController@create_cover_image_post');
Route::get('change-catarine-profile-info', 'CatarineController@change_catarine_profile_info');
Route::post('change-catarine-profile-info-post', 'CatarineController@change_catarine_profile_info_post');

//product upload code by catarine
Route::get('create-product-by-catarine', 'ProductController@create_product_by_catarine');
Route::get('all-catarine-food', 'CatarineController@all_catarine_food');
Route::get('edit-catarine-food/{id}', 'CatarineController@edit_catarine_food');
Route::post('edit-product-by-catarine-post', 'CatarineController@edit_product_by_catarine_post');
Route::post('create-product-by-catarine-post', 'ProductController@create_product_by_catarine_post');
Route::post('products/get_discount', 'ProductController@get_discount');
Route::post('add-to-cart', 'ProductController@add_to_cart');
Route::post('delete-from-cart', 'ProductController@delete_from_cart');
Route::post('post-product-comment', 'ProductController@post_product_comment');
//this route is for cart show
Route::get('view-cart', 'ProductController@view_cart');
Route::get('remove-from-cart-page/{id}', 'ProductController@remove_from_cart_page');
//this code is for create order and payment gateway
Route::post('create-order', 'ProductController@create_order');
Route::get('connector', 'ProductController@connector');
Route::get('checkout', 'ProductController@checkout');
Route::get('confirmation', 'ProductController@confirmation');
Route::get('notification', 'ProductController@notification');
Route::get('order-details/{id}', 'HomeController@order_details');
//
Route::get('all-incoming-orders', 'ProductController@all_incoming_orders');
Route::get('admin-order-details/{id}', 'ProductController@admin_order_details');
Route::get('order-direct-confirmation/{id}', 'ProductController@order_direct_confirmation');
Route::get('all-confirmed-orders', 'ProductController@all_confirmed_orders');
Route::get('get-order-details-by-admin/{id}', 'ProductController@get_order_details_by_admin');
Route::post('get-current-order', 'ProductController@get_current_order');

//catarine profile
Route::post('create-product-images-by-catarine-post', 'ProductController@create_product_images_by_catarine_post');
Route::get('delete-detail-image/{id}', 'ProductController@delete_detail_image');
Route::get('all-detail-images-by-catarine/{id}', 'ProductController@all_detail_images_by_catarine');
Route::get('change-image-by-catarine/{id}', 'ProductController@change_image_by_catarine');
Route::post('change-image-by-catarine-post', 'ProductController@change_image_by_catarine_post');
//Clear route cache:
Route::get('route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache cleared';
});
//Clear config cache:
Route::get('config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear application cache:
Route::get('clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache:
Route::get('view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});
