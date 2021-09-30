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

// Course
Route::get('/admin/course', '\Ajifatur\Campusnet\Http\Controllers\CourseController@index')->name('admin.course.index');
Route::get('/admin/course/create', '\Ajifatur\Campusnet\Http\Controllers\CourseController@create')->name('admin.course.create');
Route::post('/admin/course/store', '\Ajifatur\Campusnet\Http\Controllers\CourseController@store')->name('admin.course.store');
Route::get('/admin/course/detail/{id}', '\Ajifatur\Campusnet\Http\Controllers\CourseController@detail')->name('admin.course.detail');
Route::get('/admin/course/edit/{id}', '\Ajifatur\Campusnet\Http\Controllers\CourseController@edit')->name('admin.course.edit');
Route::post('/admin/course/update', '\Ajifatur\Campusnet\Http\Controllers\CourseController@update')->name('admin.course.update');
Route::post('/admin/course/delete', '\Ajifatur\Campusnet\Http\Controllers\CourseController@delete')->name('admin.course.delete');

// Topic
Route::get('/admin/course/topic/create/{course_id}', '\Ajifatur\Campusnet\Http\Controllers\TopicController@create')->name('admin.topic.create');
Route::post('/admin/topic/store', '\Ajifatur\Campusnet\Http\Controllers\TopicController@store')->name('admin.topic.store');
Route::get('/admin/course/topic/edit/{course_id}/{topic_id}', '\Ajifatur\Campusnet\Http\Controllers\TopicController@edit')->name('admin.topic.edit');
Route::post('/admin/topic/update', '\Ajifatur\Campusnet\Http\Controllers\TopicController@update')->name('admin.topic.update');
Route::post('/admin/topic/delete', '\Ajifatur\Campusnet\Http\Controllers\TopicController@delete')->name('admin.topic.delete');
Route::post('/admin/topic/sort', '\Ajifatur\Campusnet\Http\Controllers\TopicController@sort')->name('admin.topic.sort');

// Topic
Route::get('/admin/course/material/create/{course_id}/{topic_id}', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@create')->name('admin.material.create');
Route::post('/admin/material/store', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@store')->name('admin.material.store');
Route::get('/admin/course/material/create/{course_id}/{topic_id}/{material_id}', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@edit')->name('admin.material.edit');
Route::post('/admin/material/update', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@update')->name('admin.material.update');