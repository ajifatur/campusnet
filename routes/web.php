<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['campusnet.guest']], function() {
    // Home
    Route::get('/', '\Ajifatur\Campusnet\Http\Controllers\Site\HomeController@index')->name('site.home');

    // Course
    Route::get('/course', '\Ajifatur\Campusnet\Http\Controllers\Site\CourseController@index')->name('site.course.index');

    // Login
    Route::get('/login', '\Ajifatur\Campusnet\Http\Controllers\LoginController@show')->name('auth.login');
    Route::post('/login', '\Ajifatur\Campusnet\Http\Controllers\LoginController@authenticate')->name('auth.post-login');

    if(config('campusnet.settings.socialite') == true) {
        // Socialite
        Route::get('/auth/{provider}', '\Ajifatur\Campusnet\Http\Controllers\LoginController@redirectToProvider')->name('auth.login.provider');
        Route::get('/auth/{provider}/callback', '\Ajifatur\Campusnet\Http\Controllers\LoginController@handleProviderCallback')->name('auth.login.callback-provider');
    }
});

Route::group(['middleware' => ['campusnet.user']], function() {
    // Logout
    Route::post('/logout', '\Ajifatur\Campusnet\Http\Controllers\LoginController@logout')->name('auth.logout');

    // Dashboard
    Route::get('/admin', '\Ajifatur\Campusnet\Http\Controllers\DashboardController@index')->name('admin.dashboard');

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

    // Material
    Route::get('/admin/course/material/create/{course_id}/{topic_id}', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@create')->name('admin.material.create');
    Route::post('/admin/material/store', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@store')->name('admin.material.store');
    Route::get('/admin/course/material/detail/{course_id}/{topic_id}/{material_id}', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@detail')->name('admin.material.detail');
    Route::get('/admin/course/material/edit/{course_id}/{topic_id}/{material_id}', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@edit')->name('admin.material.edit');
    Route::post('/admin/material/update', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@update')->name('admin.material.update');
    Route::post('/admin/material/delete', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@delete')->name('admin.material.delete');
    Route::post('/admin/material/sort', '\Ajifatur\Campusnet\Http\Controllers\MaterialController@sort')->name('admin.material.sort');

    // Category
    Route::get('/admin/category', '\Ajifatur\Campusnet\Http\Controllers\CategoryController@index')->name('admin.category.index');
    Route::get('/admin/category/create', '\Ajifatur\Campusnet\Http\Controllers\CategoryController@create')->name('admin.category.create');
    Route::post('/admin/category/store', '\Ajifatur\Campusnet\Http\Controllers\CategoryController@store')->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', '\Ajifatur\Campusnet\Http\Controllers\CategoryController@edit')->name('admin.category.edit');
    Route::post('/admin/category/update', '\Ajifatur\Campusnet\Http\Controllers\CategoryController@update')->name('admin.category.update');
    Route::post('/admin/category/delete', '\Ajifatur\Campusnet\Http\Controllers\CategoryController@delete')->name('admin.category.delete');

    // Media
    Route::get('/admin/media', '\Ajifatur\Campusnet\Http\Controllers\MediaController@index')->name('admin.media.index');
    Route::get('/admin/media/create', '\Ajifatur\Campusnet\Http\Controllers\MediaController@create')->name('admin.media.create');
    Route::post('/admin/media/store', '\Ajifatur\Campusnet\Http\Controllers\MediaController@store')->name('admin.media.store');
    Route::get('/admin/media/edit/{id}', '\Ajifatur\Campusnet\Http\Controllers\MediaController@edit')->name('admin.media.edit');
    Route::post('/admin/media/update', '\Ajifatur\Campusnet\Http\Controllers\MediaController@update')->name('admin.media.update');
    Route::post('/admin/media/delete', '\Ajifatur\Campusnet\Http\Controllers\MediaController@delete')->name('admin.media.delete');

    // User
    Route::get('/admin/user', '\Ajifatur\Campusnet\Http\Controllers\UserController@index')->name('admin.user.index');
    Route::get('/admin/user/create', '\Ajifatur\Campusnet\Http\Controllers\UserController@create')->name('admin.user.create');
    Route::post('/admin/user/store', '\Ajifatur\Campusnet\Http\Controllers\UserController@store')->name('admin.user.store');
    Route::get('/admin/user/edit/{id}', '\Ajifatur\Campusnet\Http\Controllers\UserController@edit')->name('admin.user.edit');
    Route::post('/admin/user/update', '\Ajifatur\Campusnet\Http\Controllers\UserController@update')->name('admin.user.update');
    Route::post('/admin/user/delete', '\Ajifatur\Campusnet\Http\Controllers\UserController@delete')->name('admin.user.delete');

    // Role
    Route::get('/admin/role', '\Ajifatur\Campusnet\Http\Controllers\RoleController@index')->name('admin.role.index');
    Route::get('/admin/role/create', '\Ajifatur\Campusnet\Http\Controllers\RoleController@create')->name('admin.role.create');
    Route::post('/admin/role/store', '\Ajifatur\Campusnet\Http\Controllers\RoleController@store')->name('admin.role.store');
    Route::get('/admin/role/edit/{id}', '\Ajifatur\Campusnet\Http\Controllers\RoleController@edit')->name('admin.role.edit');
    Route::post('/admin/role/update', '\Ajifatur\Campusnet\Http\Controllers\RoleController@update')->name('admin.role.update');
    Route::post('/admin/role/delete', '\Ajifatur\Campusnet\Http\Controllers\RoleController@delete')->name('admin.role.delete');

    // Permission
    Route::get('/admin/permission', '\Ajifatur\Campusnet\Http\Controllers\PermissionController@index')->name('admin.permission.index');
    Route::get('/admin/permission/create', '\Ajifatur\Campusnet\Http\Controllers\PermissionController@create')->name('admin.permission.create');
    Route::post('/admin/permission/store', '\Ajifatur\Campusnet\Http\Controllers\PermissionController@store')->name('admin.permission.store');
    Route::get('/admin/permission/edit/{id}', '\Ajifatur\Campusnet\Http\Controllers\PermissionController@edit')->name('admin.permission.edit');
    Route::post('/admin/permission/update', '\Ajifatur\Campusnet\Http\Controllers\PermissionController@update')->name('admin.permission.update');
    Route::post('/admin/permission/delete', '\Ajifatur\Campusnet\Http\Controllers\PermissionController@delete')->name('admin.permission.delete');
    Route::post('/admin/permission/sort', '\Ajifatur\Campusnet\Http\Controllers\PermissionController@sort')->name('admin.permission.sort');
    Route::post('/admin/permission/change', '\Ajifatur\Campusnet\Http\Controllers\PermissionController@change')->name('admin.permission.change');

    // User Settings
    Route::get('/admin/settings/profile', '\Ajifatur\Campusnet\Http\Controllers\UserSettingController@profile')->name('admin.settings.profile');
    Route::post('/admin/settings/profile/update', '\Ajifatur\Campusnet\Http\Controllers\UserSettingController@updateProfile')->name('admin.settings.profile.update');
    Route::get('/admin/settings/account', '\Ajifatur\Campusnet\Http\Controllers\UserSettingController@account')->name('admin.settings.account');
    Route::post('/admin/settings/account/update', '\Ajifatur\Campusnet\Http\Controllers\UserSettingController@updateAccount')->name('admin.settings.account.update');
    Route::get('/admin/settings/password', '\Ajifatur\Campusnet\Http\Controllers\UserSettingController@password')->name('admin.settings.password');
    Route::post('/admin/settings/password/update', '\Ajifatur\Campusnet\Http\Controllers\UserSettingController@updatePassword')->name('admin.settings.password.update');
});