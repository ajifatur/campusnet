<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Media
Route::get('/media', '\Ajifatur\Campusnet\Http\Controllers\MediaController@index')->name('api.media.index');
Route::post('/media/upload', '\Ajifatur\Campusnet\Http\Controllers\MediaController@upload')->name('api.media.upload');

// Country Code
Route::get('/country-code', function() {
    return response()->json(country(), 200);
})->name('api.country-code');