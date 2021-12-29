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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => '/api'], function() {
    Route::get('v1/auth/info', 'App\Http\Controllers\Auth\InfoController@info');
    Route::post('v1/auth/register', 'App\Http\Controllers\Auth\RegisterController@register');
    Route::post('v1/auth/login', 'App\Http\Controllers\Auth\LoginController@login');


    Route::group(['middleware' => 'auth'], function() {
        Route::post('v1/auth/logout', 'App\Http\Controllers\Auth\LoginController@logout');
        Route::get('v1/medial/files/get-list', 'App\Http\Controllers\Media\File\GetListController@get');
        Route::get('v1/medial/files/get-file', 'App\Http\Controllers\Media\File\GetFileController@get');
        Route::get('v1/medial/folders/get-tree', 'App\Http\Controllers\Media\Folder\GetFolderTreeController@get');
        Route::get('v1/medial/folders/get-list', 'App\Http\Controllers\Media\Folder\GetFolderListController@get');
        Route::post('v1/medial/folders/get-list', 'App\Http\Controllers\Media\Folder\GetFolderListController@get');
        Route::resource('v1/medial/folders/resource', 'App\Http\Controllers\Media\Folder\FolderResourceController');



    });
});
