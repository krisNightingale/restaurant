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
    return view('admin.dashboard');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'Admin\AdminController@index');
    Route::resource('/roles', 'Admin\RolesController');
    Route::resource('/permissions', 'Admin\PermissionsController');
    Route::resource('/users', 'Admin\UsersController');
    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    Route::post('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('supply/suppliers', 'Supply\\SuppliersController');
    Route::resource('supply/supply', 'Supply\\SupplyController');
    Route::resource('category/category', 'Products\\CategoryController');
    Route::resource('measures', 'Products\\MeasuresController');
    Route::resource('products', 'Products\\ProductsController');
    Route::resource('dishes', 'Products\\DishesController');
    Route::resource('clients', 'Orders\\ClientsController');
    Route::resource('orders', 'Orders\\OrdersController');
});