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

Route::get('/', function() {
    return 'Hello world!';
});

Route::get('/admin/course', '\Ajifatur\Campusnet\Http\Controllers\CourseController@index')->name('admin.course.index');
Route::get('/admin/course/create', '\Ajifatur\Campusnet\Http\Controllers\CourseController@create')->name('admin.course.create');
Route::post('/admin/course/store', '\Ajifatur\Campusnet\Http\Controllers\CourseController@store')->name('admin.course.store');