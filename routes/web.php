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
    Route::get('user/add', 'adminUserController@add')->middleware('CheckPermission:user.add');
    Route::post('user/store', 'adminUserController@store')->middleware('CheckPermission:user.add');
    Route::get('user/delete/{id}', 'adminUserController@delete')->middleware('CheckPermission:user.delete');
    Route::get('user/forcedelete/{id}', 'adminUserController@forceDelete')->middleware('CheckPermission:user.delete');
    Route::get('user/restore/{id}', 'adminUserController@restore')->middleware('CheckPermission:user.delete');
    Route::post('user/action', 'adminUserController@action');
    Route::get('user/edit/{id}', 'adminUserController@edit')->name('user.edit')->middleware('CheckPermission:user.update');
    Route::post('user/update/{id}', 'adminUserController@update')->name('user.update')->middleware('CheckPermission:user.update');

    Route::get('role/add', 'adminRoleController@add')->middleware('CheckPermission:role.add');
    Route::post('role/addHandle', 'adminRoleController@addHandle')->name('role.addHandle')->middleware('CheckPermission:role.add');
    Route::get('role/list', 'adminRoleController@list')->name('role.list')->middleware('CheckPermission:role.view');
    Route::get('role/delete/{id}', 'adminRoleController@delete')->middleware('CheckPermission:role.delete');
    Route::get('role/edit/{role}', 'adminRoleController@edit')->name('role.edit')->middleware('CheckPermission:role.update');
    Route::post('role/update/{role}', 'adminRoleController@update')->name('role.update')->middleware('CheckPermission:role.update');

    Route::get('permission/add', 'PermissionController@add')->name('permission.add')->middleware('CheckPermission:permission.add');
    Route::post('permission/store', 'PermissionController@store')->name('permission.store')->middleware('CheckPermission:permission.add');
    Route::get('permission/update/{id}', 'PermissionController@update')->name('permission.update')->middleware('CheckPermission:permission.update');
    Route::post('permission/handleUpdate/{id}', 'PermissionController@handleUpdate')->name('permission.handleUpdate')->middleware('CheckPermission:permission.update');
    Route::get('permission/delete/{id}', 'PermissionController@delete')->name('permission.delete')->middleware('CheckPermission:permission.delete');

    Route::get('product/list', 'adminProductController@list')->name('product.view')->middleware('CheckPermission:product.view');
    Route::get('product/add', 'adminProductController@add')->name('product.add')->middleware('CheckPermission:product.add');
    Route::post('product/handle', 'adminProductController@handle')->name('product.handle')->middleware('CheckPermission:product.add');
    Route::get('product/cat', 'adminProductController@category')->name('product.cat')->middleware('CheckPermission:product.add');
    Route::post('product/cat/add', 'adminProductController@category_add')->name('product.cat.add')->middleware('CheckPermission:product.add');
    Route::get('product/cat/delete/{cat}', 'adminProductController@cat_delete')->name('product.cat.delete')->middleware('CheckPermission:product.delete');
    Route::get('product/color', 'adminProductController@color')->name('product.color')->middleware('CheckPermission:product.add');
    Route::get('product/config', 'adminProductController@config')->name('product.config')->middleware('CheckPermission:product.add');
    Route::get('product/config/edit/{config}', 'adminProductController@config_edit')->name('product.config.edit')->middleware('CheckPermission:product.add');
    Route::post('product/config/update/{config}', 'adminProductController@config_update')->name('product.config.update')->middleware('CheckPermission:product.add');
    Route::post('product/config/add', 'adminProductController@config_add')->name('product.config.add')->middleware('CheckPermission:product.add');
    Route::get('product/config/delete/{config}', 'adminProductController@config_delete')->name('product.config.delete')->middleware('CheckPermission:product.delete');
    Route::post('product/col/add', 'adminProductController@color_add')->name('product.color.add');
    Route::get('product/col/edit/{color}', 'adminProductController@edit')->name('product.color.edit');
    Route::post('product/col/update/{color}', 'adminProductController@color_update')->name('product.color.update');


    Route::get('dropzonejs/view', 'adminDropzonejs@view')->name('dropzonejs.view');
    Route::post('dropzonejs/add', 'adminDropzonejs@add')->name('dropzonejs.add');
});


//===================CLIENT==================
Route::get('/', function () {
    return view('client.home');
});
