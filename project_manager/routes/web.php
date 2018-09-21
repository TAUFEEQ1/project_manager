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

Route::post('/login','LoginController@login');
Route::post('/dashboard_data','DashboardController@index');
Route::apiResource('/tasks','TasksController');
Route::post('/taskz/compute','TasksController@compute');
Route::apiResource('/resources','ResourceController');
Route::post('/resources/show','ResourceController@show');
Route::post('/resourcez/cqty','ResourceController@cqty');
Route::post('/projectz/unarchive','ProjectsController@unarchive');
Route::post('/projectz1/archive','ProjectsController@archive');
Route::post('/projectz2/create','ProjectsController@create');
Route::get('/dashboard/projects',function(){
	return redirect('/dashboard');
});
Route::get('/dashboard/tasks',function(){
	return redirect('/dashboard/');
});
Route::post('/forgot_login','LoginController@forgot_password');
Route::get('/', 'LoginController@index');
Route::get('/dashboard','LoginController@index');
