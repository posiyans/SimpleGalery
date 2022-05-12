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

// Auth
Route::post('/v1/auth/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/v1/auth/check-token', 'App\Http\Controllers\Auth\CheckRegtokenController@index');
Route::post('/v1/auth/register', 'App\Http\Controllers\Auth\RegisterController@register');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//


//Route::get('test', function (Request $request) {
//    return 'test';
//});

Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::post('/v1/medial/folders/upload-image-in-gallery', 'App\Http\Controllers\Media\Gallery\UploadFileInGalleryController@index');
    Route::get('/v1/medial/gallery/get-image-list', 'App\Http\Controllers\Media\Gallery\GetImageListForGalleryController@index');
    Route::get('/v1/medial/gallery/get-image-info', 'App\Http\Controllers\Media\Folder\GetInfoForImageController@index');
    Route::get('/v1/medial/files/get-list', 'App\Http\Controllers\Media\File\GetListController@get');
    Route::get('/v1/medial/files/get-file', 'App\Http\Controllers\Media\File\GetFileController@get');
    Route::get('/v1/medial/folders/get-tree', 'App\Http\Controllers\Media\Folder\GetFolderTreeController@get');
    Route::get('/v1/medial/folders/get-list', 'App\Http\Controllers\Media\Folder\GetFolderListController@get');
    Route::post('/v1/medial/folders/get-list', 'App\Http\Controllers\Media\Folder\GetFolderListController@get');
    Route::resource('/v1/medial/folders/resource', 'App\Http\Controllers\Media\Folder\FolderResourceController');


});



