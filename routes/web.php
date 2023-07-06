<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//================ADMIN==================
// Route::get('/home', 'HomeController@index')->name('home');

Route::get('login', 'adminAuthController@login')->name('login');
Route::get('logout', 'adminAuthController@logout')->name('logout');
Route::post('handle', 'adminAuthController@handle')->name('handle.login');


Route::middleware('CheckLogin')->prefix('admin')->group(function () {
    Route::get('dashboard', 'AdminDashBoardController@dashboard');

    Route::get('user/list', 'adminUserController@list')->middleware('CheckPermission:user.view');
    Route::get('user/add', 'adminUserController@add')->name('admin.user.add')->middleware('CheckPermission:user.add');
    Route::post('user/store', 'adminUserController@store')->middleware('CheckPermission:user.add');
    Route::get('user/delete/{id}', 'adminUserController@delete')->middleware('CheckPermission:user.delete');
    Route::get('user/forcedelete/{id}', 'adminUserController@forceDelete')->middleware('CheckPermission:user.delete');
    Route::get('user/restore/{id}', 'adminUserController@restore')->middleware('CheckPermission:user.delete');
    Route::post('user/action', 'adminUserController@action');
    Route::get('user/edit/{id}', 'adminUserController@edit')->name('user.edit')->middleware('CheckPermission:user.update');
    Route::post('user/update/{id}', 'adminUserController@update')->name('user.update')->middleware('CheckPermission:user.update');

    Route::get('role/add', 'adminRoleController@add')->name('admin.role.add')->middleware('CheckPermission:role.add');
    Route::post('role/addHandle', 'adminRoleController@addHandle')->name('role.addHandle')->middleware('CheckPermission:role.add');
    Route::get('role/list', 'adminRoleController@list')->name('role.list')->middleware('CheckPermission:role.view');
    Route::get('role/delete/{id}', 'adminRoleController@delete')->middleware('CheckPermission:role.delete');
    Route::get('role/edit/{role}', 'adminRoleController@edit')->name('role.edit')->middleware('CheckPermission:role.update');
    Route::post('role/update/{role}', 'adminRoleController@update')->name('role.update')->middleware('CheckPermission:role.update');

    Route::get('permission/add', 'adminPermissionController@add')->name('permission.add')->middleware('CheckPermission:permission.add');
    Route::post('permission/store', 'adminPermissionController@store')->name('permission.store')->middleware('CheckPermission:permission.add');
    Route::get('permission/update/{id}', 'adminPermissionController@update')->name('permission.update')->middleware('CheckPermission:permission.update');
    Route::post('permission/handleUpdate/{id}', 'adminPermissionController@handleUpdate')->name('permission.handleUpdate')->middleware('CheckPermission:permission.update');
    Route::get('permission/delete/{id}', 'adminPermissionController@delete')->name('permission.delete')->middleware('CheckPermission:permission.delete');

    Route::get('product/list', 'adminProductController@list')->name('product.view')->middleware('CheckPermission:product.view');
    Route::get('product/add', 'adminProductController@add')->name('product.add')->middleware('CheckPermission:product.add');
    Route::post('product/handle_add', 'adminProductController@handle_add')->name('product.handle.add')->middleware('CheckPermission:product.add');
    Route::get('product/edit/{product}', 'adminProductController@product_edit')->name('product.edit')->middleware('CheckPermission:product.update');
    Route::post('product/update/{product}', 'adminProductController@product_update')->name('product.update')->middleware('CheckPermission:product.update');
    Route::get('product/cat', 'adminProductController@category')->name('product.cat')->middleware('CheckPermission:product.add');
    Route::post('product/cat/add', 'adminProductController@category_add')->name('product.cat.add')->middleware('CheckPermission:product.add');
    Route::post('product/cat/edit/{cat}', 'adminProductController@cat_edit')->name('product.cat.edit')->middleware('CheckPermission:product.update');
    Route::post('product/cat/update/{cat}', 'adminProductController@cat_update')->name('product.cat.update')->middleware('CheckPermission:product.update');
    Route::get('product/cat/delete/{cat}', 'adminProductController@cat_delete')->name('product.cat.delete')->middleware('CheckPermission:product.delete');
    Route::get('product/color', 'adminProductController@color')->name('product.color')->middleware('CheckPermission:product.add');
    Route::get('product/config', 'adminProductController@config')->name('product.config')->middleware('CheckPermission:product.add');
    Route::post('product/config/edit/{config}', 'adminProductController@config_edit')->name('product.config.edit')->middleware('CheckPermission:product.update');
    Route::post('product/config/update/{config}', 'adminProductController@config_update')->name('product.config.update')->middleware('CheckPermission:product.update');
    Route::post('product/config/add', 'adminProductController@config_add')->name('product.config.add')->middleware('CheckPermission:product.add');
    Route::get('product/config/delete/{config}', 'adminProductController@config_delete')->name('product.config.delete')->middleware('CheckPermission:product.delete');
    Route::post('product/col/add', 'adminProductController@color_add')->name('product.color.add')->middleware('CheckPermission:product.add');
    Route::post('product/col/edit/{color}', 'adminProductController@edit')->name('product.color.edit')->middleware('CheckPermission:product.update');
    Route::post('product/col/update/{color}', 'adminProductController@color_update')->name('product.color.update')->middleware('CheckPermission:product.update');
    Route::get('product/col/delete/{color}', 'adminProductController@color_delete')->name('product.color.delete')->middleware('CheckPermission:product.delete');

    Route::get('slider/list', 'adminSliderController@index')->name('admin.slider.list')->middleware('CheckPermission:slider.view');
    Route::get('slider/add', 'adminSliderController@add')->name('admin.slider.add')->middleware('CheckPermission:slider.add');
    Route::post('slider/handle_add', 'adminSliderController@handle_add')->name('admin.slider.handle_add')->middleware('CheckPermission:slider.add');
    Route::post('slider/edit/{slider}', 'adminSliderController@edit')->name('admin.slider.edit')->middleware('CheckPermission:slider.update');
    Route::post('slider/update/{slider}', 'adminSliderController@update')->name('admin.slider.update')->middleware('CheckPermission:slider.update');
    Route::get('slider/delete/{slider}', 'adminSliderController@delete')->name('admin.slider.delete')->middleware('CheckPermission:slider.delete');


    Route::get('banner/list', 'adminBannerController@index')->name('admin.banner.list')->middleware('CheckPermission:banner.view');
    Route::get('banner/add', 'adminBannerController@add')->name('admin.banner.add')->middleware('CheckPermission:banner.add');
    Route::post('banner/handle_add', 'adminBannerController@handle_add')->name('admin.banner.handle_add')->middleware('CheckPermission:banner.add');
    Route::post('banner/edit/{banner}', 'adminBannerController@edit')->name('admin.banner.edit')->middleware('CheckPermission:banner.update');
    Route::post('banner/update/{banner}', 'adminBannerController@update')->name('admin.banner.update')->middleware('CheckPermission:banner.update');
    Route::get('banner/delete/{banner}', 'adminBannerController@delete')->name('admin.banner.delete')->middleware('CheckPermission:banner.delete');

    Route::get('page/show', 'adminPageController@index')->name('admin.page.show')->middleware('CheckPermission:page.view');
    Route::get('page/add', 'adminPageController@add')->name('admin.page.add')->middleware('CheckPermission:page.add');
    Route::post('page/handle_add', 'adminPageController@handle_add')->name('admin.page.handle_add')->middleware('CheckPermission:page.add');
    Route::get('page/edit/{page}', 'adminPageController@edit')->name('admin.page.edit')->middleware('CheckPermission:page.update');
    Route::post('page/update/{page}', 'adminPageController@update')->name('admin.page.update')->middleware('CheckPermission:page.update');
    Route::get('page/delete/{page}', 'adminPageController@delete')->name('admin.page.delete')->middleware('CheckPermission:page.delete');
});

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//===================CLIENT==================
Route::get('/', 'HomeController@index')->name('home');
Route::get('trang-chu', 'HomeController@index')->name('home');

Route::get('danh-muc/{slug}', 'ProductController@product_cat')->name('client.product.cat');
Route::prefix('san-pham')->group(function () {
    Route::get('', 'ProductController@list_product')->name('client.product.show');
    Route::get('{slug}', 'ProductController@product_detail')->name('client.product.detail');
    Route::post('add/option', 'ProductController@product_option')->name('client.product.option');
});


Route::get('gio-hang', 'CartController@index')->name('client.cart.show');
Route::get('gio-hang/{slug}', 'CartController@add')->name('client.cart.add');
Route::post('cart/update', 'CartController@update_ajax')->name('client.cart.update');
Route::get('xoa-san-pham/{rowId}', 'CartController@delete')->name('client.cart.delete');
Route::get('xoa-gio-hang', 'CartController@destroy')->name('client.cart.destroy');
Route::get('cart/checkout', 'CartController@checkout')->name('client.cart.checkout');
Route::get('{slug}', 'PageController@index')->name('client.page.show');
