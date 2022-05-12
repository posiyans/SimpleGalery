<?php

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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/api/v1/auth/info', 'App\Http\Controllers\Auth\InfoController@info');
    Route::post('/api/v1/auth/logout', 'App\Http\Controllers\Auth\LoginController@logout');
});
Route::group(['middleware' => ['auth']], function() {
    Route::get('/api/v1/medial/folders/get-gallery-image', 'App\Http\Controllers\Media\Folder\GetImageForGalleryController@index');
    Route::get('/api/v1/medial/gallery/get-gallery-preview', [\App\Http\Controllers\Media\Gallery\GetPreviewForGalleryController::class, 'index']);
});
