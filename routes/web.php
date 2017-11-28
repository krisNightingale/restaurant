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

Route::get('/home', function () {
    return view('admin.dashboard');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'Admin\AdminController@index');
    Route::resource('/roles', 'Admin\RolesController');
    Route::resource('/permissions', 'Admin\PermissionsController');
    Route::resource('/users', 'Admin\UsersController');
    Route::get('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
    Route::post('/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('supply/suppliers', 'Supply\\SuppliersController')->middleware('manager');
    Route::get('supply/supply/sort', 'Supply\\SupplyController@sort')->middleware('manager');
    Route::get('supply/supply/filter', 'Supply\\SupplyController@filter')->middleware('manager');
    Route::resource('supply/supply', 'Supply\\SupplyController')->middleware('manager');
    Route::resource('category/category', 'Products\\CategoryController')->middleware('manager');
    Route::resource('measures', 'Products\\MeasuresController')->middleware('manager');
    Route::get('products/sort', 'Products\\ProductsController@sort')->middleware('manager');
    Route::get('products/filter', 'Products\\ProductsController@filter')->middleware('manager');
    Route::resource('products', 'Products\\ProductsController')->middleware('manager');
    Route::get('dishes/sort', 'Products\\DishesController@sort')->middleware('manager');
    Route::get('dishes/filter', 'Products\\DishesController@filter')->middleware('manager');
    Route::resource('dishes', 'Products\\DishesController')->middleware('manager');
    Route::resource('clients', 'Orders\\ClientsController');
    Route::get('orders/sort', 'Orders\\OrdersController@sort');
    Route::get('orders/filter', 'Orders\\OrdersController@filter');
    Route::resource('orders', 'Orders\\OrdersController');
});