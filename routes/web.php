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
Route::get('/', 'PageController@default');
Route::get('test', 'PageController@test');
Route::group([
    'prefix' => 'admin'
], function () {
    Route::get('/login', 'PageController@login');
    Route::post('/login', 'AdminController@postLogin');
    Route::get('/logout', 'AdminController@logout');
    Route::get('/register', 'PageController@register');
    Route::post('/register', 'AdminController@postRegister');
    Route::group([
        'middleware' => 'admin'
    ], function() {
        Route::get('/', 'PageController@index');
        Route::get('/foods', 'PageController@foods');

        //Analyst
        Route::get('/analyst-revenue', 'PageController@analystRevenue');
        Route::get('/analyst-cart', 'PageController@analystCart');
        Route::get('/analyst-food', 'PageController@analystFood');

        Route::get('/revenue-chart/{month}/{year}/{type}', 'APIController@revenueChart');
        Route::get('/cart-chart/{month}/{year}/{type}', 'APIController@revenueChart');

        //User 
        Route::get('/users', 'PageController@pageUsers');
        Route::get('/edit-user/{id}', 'PageController@pageEditUser');
        Route::post('/edit-user/{id}', 'AdminController@postEditUser');
        Route::get('/create-user', 'PageController@pageAddUser');
        Route::post('/create-user', 'AdminController@postAddUser');

        Route::get('/delete-user/{id}', 'AdminController@deleteUser');

        //Category
        Route::get('/categories', 'PageController@pageCategories');
        Route::get('/create-category', 'PageController@pageAddCategory');
        Route::post('/create-category', 'AdminController@postAddCategory');
        Route::get('/edit-category/{id}', 'PageController@editCategory');
        Route::post('/edit-category/{id}', 'AdminController@editCategory');
        Route::get('/delete-category/{id}', 'AdminController@deleteCategory');

        //Food 
        Route::get('/foods', 'PageController@pageFoods');
        Route::get('/create-food', 'PageController@pageAddFood');
        Route::post('/create-food', 'AdminController@postAddFood');
        Route::get('/edit-food/{id}', 'PageController@pageEditFood');
        Route::post('/edit-food/{id}', 'AdminController@postEditFood');
        Route::get('/delete-food/{id}', 'AdminController@deleteFood');

        //Cart
        Route::get('/carts/{type}', 'PageController@pageCarts');
        Route::get('/carts/change-status/{id}', 'AdminController@changeStatus');
        Route::get('/delete-cart/{id}', 'AdminController@deleteCart');
    });
});
