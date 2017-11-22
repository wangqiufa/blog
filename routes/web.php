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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 后台用户管理
Route::get('admin/user/index', 'admin\UserController@index');
Route::get('admin/user/add', 'admin\UserController@add');
Route::post('admin/user/addDo', 'admin\UserController@addDo');
Route::get('admin/user/edit/{id}', 'admin\UserController@edit')->where('id', '[0-9]+');
Route::post('admin/user/editDo', 'admin\UserController@editDo');
Route::get('admin/user/delete/{id}', 'admin\UserController@delete');

Route::get('admin/articleCategary/index', 'admin\ArticleCategaryController@index');
Route::get('admin/articleCategary/add', 'admin\ArticleCategaryController@add');
Route::post('admin/articleCategary/addDo', 'admin\ArticleCategaryController@addDo');
Route::get('admin/articleCategary/delete/{id}', 'admin\ArticleCategaryController@delete');
Route::get('admin/articleCategary/edit/{id}', 'admin\ArticleCategaryController@edit')->where('id', '[0-9]+');
Route::post('admin/articleCategary/editDo', 'admin\ArticleCategaryController@editDo');

Route::get('admin/article/index', 'admin\ArticleController@index');
Route::get('admin/article/add', 'admin\ArticleController@add');
Route::post('admin/article/addDo', 'admin\ArticleController@addDo');
Route::get('admin/article/edit/{id}', 'admin\ArticleController@edit')->where('id', '[0-9]+');
Route::post('admin/article/editDo', 'admin\ArticleController@editDo');

Route::get('upload/test', 'common\UploadController@test');
Route::post('upload/img', 'common\UploadController@img');
